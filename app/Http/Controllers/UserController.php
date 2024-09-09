<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Controllers\UserControllerService;

class UserController extends Controller
{
    public function index()
    {
        return User::paginate();
    }

    public function show(UserControllerService $service, int $id)
    {
        return $service->getData(['id' => $id]);
    }
}
