<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "admin";
        $email = "admin@alkarameh.com";
        $password = "admin@12345alkarameh12345@admin";
        User::create([
            "uuid" => Str::uuid(),
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
        ]);
    }
}
