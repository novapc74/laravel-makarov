<?php

namespace repositories;

use App\Models\User;

class UserRepository implements RepositoryInterface
{
    private const TABLE = 'users';

    public function all(): array
    {
        return User::all()->toArray();
    }

    public function find(int $id): ?object
    {
        return User::where('id', $id)->get();
    }

    public function findOneBy(array $criteria = []): ?object
    {
        return User::where(function ($query) use ($criteria) {
            foreach ($criteria as $key => $value) {
                $query->orWhere($key, $value);
            }
        })->take(1);
    }

    public function findBy(array $criteria): array
    {
        return User::where(function ($query) use ($criteria) {
            foreach ($criteria as $key => $value) {
                $query->orWhere($key, $value);
            }
        })
            ->get()
            ->toArray();
    }
}
