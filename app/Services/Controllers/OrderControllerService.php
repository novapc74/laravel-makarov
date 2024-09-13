<?php

namespace App\Services\Controllers;

use App\Exceptions\CustomException;
use App\Repositories\OrderRepository;
use App\Services\Features\ParamTrait;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class OrderControllerService
{
    use ParamTrait;

    public function __construct(private OrderRepository $orderRepository)
    {
    }

    /**
     * @throws CustomException
     */
    public function getData(mixed $params = []): LengthAwarePaginator|array
    {
        return match (self::getParamType($params)) {
            'id' => self::getOrderById($params),
            'all', '' => self::getAllOrders(),
            'filter' => self::getFilteredOrders($params),
            default => []
        };
    }

    /**
     * @throws CustomException
     */
    private function getOrderById(int $id): array
    {
        return $this->orderRepository->find($id);
    }

    /**
     * @throws CustomException
     */
    private function getAllOrders(): LengthAwarePaginator
    {
        return $this->orderRepository->getAll();
    }

    /**
     * @throws CustomException
     */
    private function getFilteredOrders(array $criteria): ?array
    {
        return $this->orderRepository->findBy($criteria['filter']);
    }
}
