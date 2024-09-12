<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Partnership;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Controllers\UserControllerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    // ../api/user?filter[email][]=firstEmail@example.ru&filter[id][]=some_id

    /**
     * @throws CustomException
     */
    public function index(Request $request, UserControllerService $service): array
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cache_locks');
        Schema::enableForeignKeyConstraints();
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
