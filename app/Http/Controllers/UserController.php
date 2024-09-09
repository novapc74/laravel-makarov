<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Controllers\UserControllerService;

class UserController extends Controller
{
    public function index(Request $request, UserControllerService $service): array
    {
        // ../api/user?filter[email][]=firstEmail@example.ru&filter[id][]=some_id
        return $service->getData($request->all());
    }

    public function show(UserControllerService $service, int $id): array
    {
        return $service->getData($id);
    }
}
