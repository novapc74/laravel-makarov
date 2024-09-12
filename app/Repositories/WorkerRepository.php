<?php

namespace App\Repositories;

use Exception;
use App\Enum\Sql;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder as QueryBuilder;

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
            return Worker::with(['workerExOrderTypes', 'orderWorkers'])->find($id)
                ?->toArray()
                ?? throw new CustomException('worker not found', 404);
        } catch (Exception $e) {
            throw new CustomException($e->getMessage() ?? 'error', 404);
        }
    }

    public function findWorkersByOrderTypeId(string $idOrderTypesCollection): array
    {
        $count = count(explode(',', $idOrderTypesCollection));

        $sql = Sql::WORKERS_BY_ORDER_TYPES->value;

        $sql = str_replace(':idOrderTypesCollection', "$idOrderTypesCollection", $sql);
        $sql = str_replace(':countOrderTypes', $count, $sql);

        $sqlResult = DB::select($sql);

        foreach ($sqlResult as $value) {
            $value->order_types = json_decode($value->order_types, true);
        }

        return $sqlResult;
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
