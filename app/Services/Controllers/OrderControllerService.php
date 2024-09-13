<?php

namespace App\Services\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderRequest\OrderPostRequest;
use App\Http\Requests\OrderRequest\OrderUpdateRequest;
use App\Models\Order;
use App\Models\OrderWorker;
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
    public function update(OrderUpdateRequest $request): void
    {
        $validated = $request->validated();

        DB::table('order_workers')->insert([
            'amount' => $validated['amount'],
            'order_id' => $validated['order_id'],
            'worker_id' => $validated['worker_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $orderWorker = OrderWorker::all()->last();

        $orderData = [
            'updated_at' => now(),
            'status' => $validated['status'],
        ];

        $order = Order::find($validated['order_id']);
        $order->update($orderData);

        $order->orderWorkers()->save($orderWorker);

        throw new CustomException(sprintf('order with id:%s updated' , $validated['order_id']), 201);
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
