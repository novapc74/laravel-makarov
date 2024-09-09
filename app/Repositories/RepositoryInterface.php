<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function getAll(): array;

    public function find(int $id): ?array;

    public function findOneBy(array $criteria): ?object;

    public function findBy(array $criteria): array;
}
