<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Akun Superadmin',
            'email' => 'superadmin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make('12345678')
        ]);

        $this->call(RoleSeeder::class);
    }
}
