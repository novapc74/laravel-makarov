<?php

namespace App\Services\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\OrderRequest\OrderPostRequest;
use App\Http\Requests\OrderRequest\OrderUpdateRequest;
use App\Models\Order;
use App\Models\OrderWorker;
use App\Models\Worker;
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

        #TODO ЗАКАТ СОЛНЦА ВРУЧНУЮ ... не разобрался как именно с моделями и их зависимостями Eloquent работает ...
        $order = Order::find($validated['order_id']);
        $order->amount -= $validated['amount'];

        $worker = Worker::find($validated['worker_id']);

        $orderWorker = new OrderWorker();
        $orderWorker->amount = $validated['amount'];
        $orderWorker->created_at = now();
        $orderWorker->updated_at = now();
        $orderWorker->worker_id = $worker->id;
        $orderWorker->order_id = $order->id;
        $orderWorker->save();

        $order->order_worker_id = $orderWorker->id;
        $order->save();

        throw new CustomException(sprintf('Order with id:%s updated', $validated['order_id']), 201);
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

    /**
     * @throws CustomException
     */
    public function delete(Order $order): array
    {
        #TODO проверяем связи, если нет привязки к исполнителям, можно удалять
        throw new CustomException('not resolved', 201);
    }
}
