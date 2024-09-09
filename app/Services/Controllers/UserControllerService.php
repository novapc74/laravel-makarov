<?php

namespace App\Services\Controllers;

use App\Repositories\UserRepository;

readonly class UserControllerService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getData(array $params = []): array
    {
        if ([] !== $params && array_key_exists('id', $params)) {
            return self::getUserById($params['id']);
        }

        return [];
    }

    private function getUserById(int $id): array
    {
        return $this->userRepository->find($id);
    }

}
