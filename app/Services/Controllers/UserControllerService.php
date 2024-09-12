<?php

namespace App\Services\Controllers;

use App\Exceptions\CustomException;
use App\Repositories\UserRepository;
use App\Services\Features\ParamTrait;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class UserControllerService
{
    use ParamTrait;

    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @throws CustomException
     */
    public function getData(mixed $params = []): array|LengthAwarePaginator
    {
        return match (self::getParamType($params)) {
            'id' => self::getUserById($params),
            'all', '' => self::getAllUsers(),
            'filter' => self::getFilteredUser($params),
            default => []
        };
    }

    /**
     * @throws CustomException
     */
    private function getFilteredUser(array $criteria): array
    {
        return $this->userRepository->findBy($criteria['filter']);
    }

    /**
     * @throws CustomException
     */
    private function getUserById(int $id): array
    {
        return $this->userRepository->find($id);
    }

    /**
     * @throws CustomException
     */
    private function getAllUsers(): LengthAwarePaginator
    {
        return $this->userRepository->getAll();
    }
}
