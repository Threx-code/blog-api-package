<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class RegisterController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        if ($request->validated()) {
            $userService = new UserService();
            return $userService->register($request);
        }
    }
}
