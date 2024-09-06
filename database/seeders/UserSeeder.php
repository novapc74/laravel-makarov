<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        array_map(
            fn() => self::setUserData(Str::random(10), Str::random(10) . '@example.com'),
            range(0, 9)
        );
    }

    private function setUserData(string $name, string $email): void
    {
        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'created_at' => now(),
            'email_verified_at' => now(),
        ]);
    }
}
