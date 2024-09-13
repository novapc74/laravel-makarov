<?php

namespace App\Services\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderRequest\OrderPostRequest;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Services\Features\ParamTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

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
    public function store(OrderPostRequest $request): void
    {
        $validated = $request->validated();

        $currentData = now();
        $validated['created_at'] = $currentData;
        $validated['updated_at'] = $currentData;
        try {

            DB::table('orders')->insert($validated);
        } catch (Exception $exception) {
            throw new CustomException($exception->getMessage(), 422);
        }

        throw new CustomException(sprintf('order saved with id:%s', Order::all()->last()->getKey()), 201);
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
