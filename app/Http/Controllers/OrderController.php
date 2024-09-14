<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\OrderRequest\OrderPostRequest;
use App\Services\Controllers\OrderControllerService;

class OrderController extends Controller
{
    /**
     * @throws CustomException
     */
    public function index(Request $request, OrderControllerService $service): LengthAwarePaginator|array
    {
        return $service->getData($request->all());
    }

    /**
     * @throws CustomException
     */
    public function show(OrderControllerService $service, int $id): array
    {
        return $service->getData($id);
    }

    /**
     * @throws CustomException
     */
    public function store(OrderControllerService $service, OrderPostRequest $request): array
    {
        $service->store($request);
    }

    /**
     * @throws CustomException
     */
    public function  update(OrderControllerService $service, OrderUpdateRequest $request): array
    {
        $service->update($request);
    }

    /**
     * @throws CustomException
     */
    public function  delete(OrderControllerService $service, Order $order): array
    {
        #TODO проверяем связи, если нет привязки к исполнителям, можно удалять
        $service->delete($order);
    }
}
