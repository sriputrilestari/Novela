<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
    if (! Schema::hasTable('reports')) {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('novel_id')->constrained('novels')->cascadeOnDelete();
            $table->string('alasan');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

        });
        }
    }
};

