<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Controllers\UserControllerService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, UserControllerService $service)
    {
        $query = $request->all();

        return $service->getData($query);
    }

    public function show(UserControllerService $service, int $id)
    {
        return $service->getData($id);
    }
}
