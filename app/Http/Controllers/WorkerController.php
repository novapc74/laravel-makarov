<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Services\Controllers\WorkerControllerService;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use JetBrains\PhpStorm\ArrayShape;

class WorkerController extends Controller
{
    /**
     * @throws CustomException
     */
    public function index(Request $request, WorkerControllerService $service): \Illuminate\Pagination\LengthAwarePaginator|array
    {
        return $service->getData($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * POST
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @throws CustomException
     */
    public function show(WorkerControllerService $service, int $id): array
    {
        return $service->getData($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Worker $worker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        //
    }
}
