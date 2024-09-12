<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    public function index()
    {
        return Worker::all()->toArray();
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
        dd($request->all());
    }

    /**
     * @throws CustomException
     */
    public function show(int $id): Worker
    {
        if (!$worker = Worker::find($id)?->first()) {
            throw new CustomException(sprintf('worker for id:%s not found', $id), 404);
        }

        return $worker;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Worker $worker)
    {
        dd($request->all(), 'update', $worker);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        //
    }
}
