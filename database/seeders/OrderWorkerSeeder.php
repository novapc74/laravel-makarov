<?php

namespace Database\Seeders;

use App\Models\OrderWorker;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderWorkerSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (self::isCount(OrderWorker::class)) {
            return;
        }
    }
}
