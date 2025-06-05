<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat Role Admin
        Role::create(['name' => 'admin']);

        // Membuat Role User
        Role::create(['name' => 'user']);
    }
}
