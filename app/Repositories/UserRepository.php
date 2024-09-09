<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UserRepository implements RepositoryInterface
{
    public function getAll(): array
    {
        return User::all()->toArray();
    }

    public function find(int $id): ?array
    {
        return User::where('id', $id)->get()->toArray()[0];
    }

    public function findOneBy(array $criteria = []): ?object
    {
        return User::where(function (QueryBuilder $query) use ($criteria) {
            foreach ($criteria as $key => $value) {
                $query->orWhere($key, 'in', $value);
            }
        })->take(1);
    }

    public function findBy(array $criteria): array
    {

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
    }
}
