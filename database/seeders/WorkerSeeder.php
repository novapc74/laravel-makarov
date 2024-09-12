<?php

namespace Database\Seeders;

use App\Models\Worker;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Number;
use Random\RandomException;


class WorkerSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;

    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            self::setWorkerData();
        }
    }

    /**
     * @throws RandomException
     */
    public function setWorkerData(): void
    {
        DB::table('workers')->insert([
            'name' => Str::random(10),
            'second_name' => Str::random(10),
            'surname' => Str::random(10),
            'phone' => random_int(79090000000, 79099999999),
            'created_at' => now(),
        ]);
    }

}
