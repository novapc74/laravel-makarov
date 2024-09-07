<?php

namespace Repositories;

interface RepositoryInterface
{
    public function getAll(): array;

    public function find(int $id): ?object;

    public function findOneBy(array $criteria): ?object;

    public function findBy(array $criteria): array;
}
