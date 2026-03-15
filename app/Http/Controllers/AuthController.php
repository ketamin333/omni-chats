<?php

namespace App\Http\Controllers;

use App\Commands\Auth\LoginCommand;
use App\Handlers\Auth\Contracts\LoginHandlerInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Support\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private LoginHandlerInterface $loginHandler,
    ) {}

    public function login(LoginRequest $request)
    {
        $auth = $this->loginHandler->handle(LoginCommand::fromRequest($request));

        if (!$auth) {
            throw new AuthenticationException('Неверный email или пароль');
        }

        return ApiResponse::success('ok');
    }

    public function logout(Request $request) {}

    public function me(Request $request)
    {
        return ApiResponse::success($request->user());
    }
}
