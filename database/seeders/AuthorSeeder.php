<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'CobaAuthor',
                'email' => 'cobaauthor@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'author',
            ],
        ]);
    }
}
