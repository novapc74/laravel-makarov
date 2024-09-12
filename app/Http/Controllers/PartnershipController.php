<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Partnership;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function index(): \Illuminate\Pagination\LengthAwarePaginator|array
    {
        return Partnership::paginate();
    }

    /**
     * @throws CustomException
     */
    public function show(int $id): Partnership
    {
        if (!$worker = Partnership::find($id)?->first()) {
            throw new CustomException(sprintf('worker for id:%s not found', $id), 404);
        }

        return $worker;
    }
}
