<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Superadmin",
            "email" => "superadmin@gmail.com",
            "password" => Hash::make("password123"),
            "role" => "superadmin",
        ]);

        User::create([
            "name" => "Admin TPL",
            "email" => "admin@tpl.svipb.ac.id",
            "password" => Hash::make("password123"),
            "role" => "admin",
        ]);

        User::create([
            "name" => "Mahasiswa IPB",
            "email" => "mahasiswa@apps.ipb.ac.id",
            "password" => Hash::make("password123"),
            "role" => "user",
        ]);

        User::create([
            "name" => "User Umum",
            "email" => "user@gmail.com",
            "password" => Hash::make("password123"),
            "role" => "user",
        ]);
    }
}
