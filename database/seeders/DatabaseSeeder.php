<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Worker;
use App\Models\OrderType;
use App\Models\Partnership;
use Illuminate\Database\Seeder;
use App\Models\WorkerExOrderType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        self::clearDb();

        $this->call([
            PartnershipSeeder::class,
            UserSeeder::class,
            OrderTypeSeeder::class,
            WorkerSeeder::class,
            WorkerExOrderTypeSeeder::class,
        ]);
    }

    private function clearDb(): void
    {
        User::all()->map(fn(User $user) => $user->unsetRelation('partnership')->delete());

        Partnership::all()->map(fn(Partnership $partnership) => $partnership->delete());

        OrderType::all()->map(fn(OrderType $partnership) => $partnership->delete());

        Worker::all()->map(fn(Worker $partnership) => $partnership->delete());

        WorkerExOrderType::all()->map(
            fn(WorkerExOrderType $workerExOrderType) => $workerExOrderType
                ->unsetRelation('worker')
                ->unsetRelation('orderType')
                ->delete()
        );
    }

}
