<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'user')->update(['role' => 'reader']);

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin','author','reader')
            NOT NULL DEFAULT 'reader'
        ");

        if (! Schema::hasColumn('users', 'author_request_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('author_request_status', ['none', 'pending', 'approved', 'rejected'])
                    ->default('none')
                    ->after('author_request');
            });
        }

        DB::statement("
            UPDATE users
            SET author_request_status = CASE
                WHEN CAST(author_request AS CHAR) IN ('1', 'pending') THEN 'pending'
                WHEN CAST(author_request AS CHAR) IN ('approved', '2') THEN 'approved'
                WHEN CAST(author_request AS CHAR) IN ('rejected', '3') THEN 'rejected'
                ELSE 'none'
            END
        ");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('author_request');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('author_request_status', 'author_request');
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'author_request_note')) {
                $table->text('author_request_note')->nullable()->after('author_request');
            }

            if (! Schema::hasColumn('users', 'author_request_date')) {
                $table->timestamp('author_request_date')->nullable()->after('author_request_note');
            }

            if (! Schema::hasColumn('users', 'author_approved_at')) {
                $table->timestamp('author_approved_at')->nullable()->after('author_request_date');
            }

            if (! Schema::hasColumn('users', 'author_rejected_at')) {
                $table->timestamp('author_rejected_at')->nullable()->after('author_approved_at');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'author_request_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('author_request_status')->default(false)->after('is_blocked');
            });
        }

        DB::statement("
            UPDATE users
            SET author_request_status = CASE
                WHEN author_request = 'pending' THEN 1
                ELSE 0
            END
        ");

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'author_request',
                'author_request_note',
                'author_request_date',
                'author_approved_at',
                'author_rejected_at',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('author_request_status', 'author_request');
        });

        DB::table('users')->where('role', 'reader')->update(['role' => 'user']);

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin','author','user')
            NOT NULL DEFAULT 'user'
        ");
    }
};
