<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@business.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
