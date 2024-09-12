<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Services\Controllers\UserControllerService;

class UserController extends Controller
{
    // ../api/user?filter[email][]=firstEmail@example.ru&filter[id][]=some_id
    /**
     * @throws CustomException
     */
    public function index(Request $request, UserControllerService $service): array
    {
        return $service->getData($request->all());
    }

    /**
     * @throws CustomException
     */
    public function show(UserControllerService $service, int $id): array
    {
        return $service->getData($id);
    }
}
