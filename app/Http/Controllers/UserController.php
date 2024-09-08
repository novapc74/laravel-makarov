<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function index()
    {
        return User::paginate();
    }

    public function show(UserRepository $userRepository,$id)
    {
        return $userRepository->find($id);
    }
}
