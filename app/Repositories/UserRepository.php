<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\User;
use Exception;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UserRepository implements RepositoryInterface
{
    /**
     * @throws CustomException
     */
    public function getAll(): array
    {
        try {
            return User::all()->toArray();
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * @throws CustomException
     */
    public function find(int $id): ?array
    {
        try {
            return User::query()->findOrFail($id)->toArray();
        } catch (Exception $exception) {
            throw new CustomException($exception->getMessage(), 404);
        }
    }

    /**
     * @throws CustomException
     */
    public function findOneBy(array $criteria = []): ?object
    {
        try {
            return User::where(function (QueryBuilder $query) use ($criteria) {
                foreach ($criteria as $key => $value) {
                    $query->orWhere($key, 'in', $value);
                }
            })->take(1);
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
