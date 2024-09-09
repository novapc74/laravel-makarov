<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll(): array;

    public function find(int $id): ?array;

    public function findOneBy(array $criteria): ?object;

    public function findBy(array $criteria): array;
}
