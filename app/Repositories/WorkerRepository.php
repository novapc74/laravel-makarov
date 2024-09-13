<?php

namespace App\Repositories;

use Exception;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerRepository implements RepositoryInterface
{

    /**
     * @throws CustomException
     */
    public function getAll(): LengthAwarePaginator
    {
        try {
            return Worker::with(['workerExOrderTypes', 'orderWorkers'])
                ->paginate();
        } catch (Exception $e) {
            throw new CustomException($e->getMessage() ?? 'error', 404);
        }
    }

    /**
     * @throws CustomException
     */
    public function find(int $id): array
    {
        try {
            return Worker::with(['workerExOrderTypes', 'orderWorkers'])
                ->find($id)
                ?->toArray()
                ?? throw new CustomException('worker not found', 404);
        } catch (Exception $e) {
            throw new CustomException($e->getMessage() ?? 'error', 404);
        }
    }

    /**
     * @throws CustomException
     */
    public function findWorkersByOrderTypeId(string $idOrderTypesCollection): LengthAwarePaginator
    {
        try {
            $filteredWorkerId = DB::table('workers')->addSelect('workers.id')
                ->leftJoin('worker_ex_order_types', 'workers.id', '=', 'worker_ex_order_types.worker_id')
                ->whereNotIn('worker_ex_order_types.order_type_id', explode(',', $idOrderTypesCollection))
                ->get()
                ->toArray();

            $workerIdCollection = array_map(fn($item) => $item->id, $filteredWorkerId);

            return Worker::with(['workerExOrderTypes', 'orderWorkers'])
                ->whereIn('id', $workerIdCollection)
                ->paginate();

        } catch (Exception $exception) {
            throw new CustomException($exception->getMessage(), 404);
        }
    }

    /**
     * @throws CustomException
     */
    public function findBy(array $criteria): array
    {
        try {
            return Worker::where(function ($query) use ($criteria) {
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
