<?php

namespace App\Http\Controllers;

use App\Helpers\Facades\ApiResponse;
use App\Services\UserService;
use \Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        return ApiResponse::success(200, ['users' => $this->userService->getAllUsers($request)], 'Success');
    }
}
