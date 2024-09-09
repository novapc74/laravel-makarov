<?php

namespace App\Services\Controllers;

use App\Repositories\UserRepository;
use App\Services\Features\ParamTrait;

readonly class UserControllerService
{
    use ParamTrait;

    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getData(mixed $params = []): array
    {
        return match (self::getParamType($params)) {
            'id' => self::getUserById($params),
            'all' => self::getAllUsers(),
            'filter' => self::getFilteredUser($params),
            default => []
        };
    }

    private function getFilteredUser(array $criteria): array
    {
        return $this->userRepository->findBy($criteria['filter']);
    }

    private function getUserById(int $id): array
    {
        return $this->userRepository->find($id);
    }

    private function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }
}
