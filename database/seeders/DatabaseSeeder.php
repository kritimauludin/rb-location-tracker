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
            'user_code' => 'SU161121',
            'name' => 'Akun Superadmin',
            'email' => 'superadmin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make('12345678')
        ]);
        \App\Models\User::factory()->create([
            'user_code' => 'A161121',
            'name' => 'Admin 16112',
            'email' => 'admin@gmail.com',
            'role_id' => 4,
            'password' => Hash::make('12345678')
        ]);
        \App\Models\User::factory()->create([
            'user_code' => 'CR161121',
            'name' => 'Rahmat',
            'email' => 'kurir@gmail.com',
            'role_id' => 3,
            'password' => Hash::make('12345678')
        ]);

        \App\Models\Newspaper::factory()->create([
            'newspaper_code' => 'NS202310091',
            'edition' => 'Koran Harian',
            'description' => 'Koran terbit harian'
        ]);

        $this->call(RoleSeeder::class);
    }
}
