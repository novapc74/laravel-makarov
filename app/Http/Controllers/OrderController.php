<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Controllers\OrderControllerService;

class OrderController extends Controller
{
    /**
     * @throws CustomException
     */
    public function index(Request $request, OrderControllerService $service): \Illuminate\Pagination\LengthAwarePaginator|array
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

    public function store(Request $request)
    {
        dd($request->all());
    }
}
