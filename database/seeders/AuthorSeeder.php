<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name'     => 'Author',
                'email'    => 'author@example.com',
                'password' => Hash::make('password'),
                'role'     => 'author',
            ],
        ]);
    }
}
