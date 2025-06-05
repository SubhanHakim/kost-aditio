<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'Nama User1',
            'email' => 'user1@email.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('user');

        $admin = \App\Models\User::create([
            'name' => 'Nama Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');
    }
}
