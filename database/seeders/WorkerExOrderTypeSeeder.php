<?php

namespace Database\Seeders;

use App\Models\Worker;
use App\Models\OrderType;
use App\Models\WorkerExOrderType;
use Illuminate\Database\Seeder;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WorkerExOrderTypeSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;

    private const EX_TYPES = [

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderTypes = OrderType::all();

        Worker::all()->map(fn(Worker $worker) => self::setExOrder($worker, $orderTypes));
    }

    private function setExOrder(Worker $worker, Collection $orderTypes): void
    {
        $randomOrderTypeCollection = $orderTypes->random(2)->toArray();

        /**@var OrderType $orderType*/
        foreach ($randomOrderTypeCollection as $orderTypeAsArray) {

            $orderType = OrderType::find($orderTypeAsArray['id']);

            $workerExOrderType = new WorkerExOrderType();

            $worker->workerExOrderTypes()->save($workerExOrderType);
            $orderType->workerExOrderTypes()->save($workerExOrderType);
        }
    }
}
