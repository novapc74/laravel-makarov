<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function getAll(): LengthAwarePaginator;

    public function find(int $id): ?array;

    public function findBy(array $criteria): array;
}
