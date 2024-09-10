<?php

namespace Database\Seeders;

use App\Models\OrderType;
use Database\Seeders\Features\CountTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTypeSeeder extends Seeder
{
    use WithoutModelEvents;
    use CountTrait;
    private const ORDER_TYPES = [
        'Погрузка/Разгрузка',
        'Такелажные работы',
        'Уборка',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (self::isCount(OrderType::class)) {
            return;
        }

        array_map(
            fn(string $type) => DB::table('order_types')->insert(['name' => $type]),
            self::ORDER_TYPES
        );
    }
}
