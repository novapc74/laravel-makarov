<?php

namespace Repositories;

use App\Models\User;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UserRepository implements RepositoryInterface
{
    public function getAll(): array
    {
        return User::all()->toArray();
    }

    public function find(int $id): ?object
    {
        return User::where('id', $id)->get();
    }

    public function findOneBy(array $criteria = []): ?object
    {
        return User::where(function (QueryBuilder $query) use ($criteria) {
            foreach ($criteria as $key => $value) {
                $query->orWhere($key, '=', $value);
            }
        })->take(1);
    }

    public function findBy(array $criteria): array
    {
        return User::where(function (QueryBuilder $query) use ($criteria) {
            foreach ($criteria as $key => $value) {
                $query->orWhere($key, '=', $value);
            }
        })
            ->get()
            ->toArray();
    }
}
