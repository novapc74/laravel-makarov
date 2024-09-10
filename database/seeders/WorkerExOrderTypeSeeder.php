<?php

namespace Database\Seeders;

use App\Models\WorkerExOrderType;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkerExOrderTypeSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (self::isCount(WorkerExOrderType::class)) {
            return;
        }
    }
}
