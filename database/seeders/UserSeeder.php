<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partnership;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (self::isCount(User::class)) {
            return;
        }

        $partnerships = Partnership::all()->toArray();

        array_map(
            fn() => self::setUserData($partnerships),
            range(0, 9)
        );
    }

    private function setUserData(array $partnerships): void
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(5) . '@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'partnership_id' => $partnerships[array_rand($partnerships)]['id']
        ]);
    }
}
