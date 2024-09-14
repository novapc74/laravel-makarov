<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\User;
use Exception;

class UserRepository implements RepositoryInterface
{
    /**
     * @throws CustomException
     */
    public function getAll(): \Illuminate\Pagination\LengthAwarePaginator
    {
        try {
            return User::paginate();
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * @throws CustomException
     */
    public function find(int $id): array
    {
        try {
            return User::with(['partnership', 'orders'])->find($id)
                ?->toArray()
                ?? throw new CustomException('user not found', 404);
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
            return User::where(function ($query) use ($criteria) {
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
