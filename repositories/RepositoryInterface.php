<?php

namespace repositories;

interface RepositoryInterface
{
    public function all(): array;

    public function find(int $id): ?object;

    public function findOneBy(array $criteria): ?object;

    public function findBy(array $criteria): array;
}
