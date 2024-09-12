<?php

namespace App\Repositories;

use Exception;
use App\Models\Order;
use App\Exceptions\CustomException;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements RepositoryInterface
{

    /**
     * @throws CustomException
     */
    public function getAll(): LengthAwarePaginator
    {
        try {
            return Order::with(['workerExOrderTypes', 'orderWorkers'])
                ->paginate();
        } catch (Exception $e) {
            throw new CustomException($e->getMessage() ?? 'error', 404);
        }
    }

    /**
     * @throws CustomException
     */
    public function find(int $id): ?array
    {
        try {
            return Order::with(['workerExOrderTypes', 'orderWorkers'])->find($id)
                ?->toArray()
                ?? throw new CustomException('order not found', 404);
        } catch (Exception $e) {
            throw new CustomException($e->getMessage() ?? 'error', 404);
        }
    }

    /**
     * @throws CustomException
     */
    public function findBy(array $criteria): array
    {
        try {
            return Order::where(function ($query) use ($criteria) {
                $keys = array_keys($criteria);
                foreach ($keys as $key) {
                    foreach ($criteria[$key] as $value) {
                        $query->orWhere($key, '=', $value);
                    }
                }
            })
                ->get()
                ->toArray();
        } catch (Exception $exception) {
            throw new CustomException($exception->getMessage(), 404);
        }
    }
}
