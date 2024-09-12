<?php

namespace Database\Seeders;

use App\Models\Partnership;
use App\Models\User;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartnershipSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        array_map(
            fn() => self::setPartnershipData(Str::random(10)),
            range(0, 9)
        );
    }

    private function setPartnershipData(string $name): void
    {
        DB::table('partnerships')->insert([
            'name' => $name,
            'created_at' => now(),
        ]);
    }
}
