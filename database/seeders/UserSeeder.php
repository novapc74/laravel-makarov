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
        $partnerships = \App\Models\Partnership::all()->toArray();

        array_map(
            fn() => self::setUserData(Str::random(10), Str::random(10) . '@example.com', $partnerships),
            range(0, 9)
        );
    }

    private function setUserData(string $name, string $email, array $partnerships): void
    {
        DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'partnership_id' => $partnerships[array_rand($partnerships)]['id']
        ]);
    }
}
