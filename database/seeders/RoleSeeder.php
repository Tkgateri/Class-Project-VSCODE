<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'This is an admin user'
        ]);
        Role::create([
            'name' => 'admin',
            'description' => 'This is a trainer'
        ]);
        Role::create([
            'name' => 'admin',
            'description' => 'This is a normal user'
        ]);
        Role::create([
            'name' => 'admin',
            'description' => 'This is a staff'
        ]);
    }
}
