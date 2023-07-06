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
        \App\Models\Role::factory()->create([
            'role_name' => 'superadmin'
        ]);
        \App\Models\Role::factory()->create([
            'role_name' => 'admin'
        ]);
        \App\Models\Role::factory()->create([
            'role_name' => 'kurir'
        ]);
    }
}
