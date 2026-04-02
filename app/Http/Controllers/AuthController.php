<?php

namespace App\Http\Controllers;

use App\Commands\Auth\LoginCommand;
use App\Handlers\Auth\Contracts\LoginHandlerInterface;
use App\Handlers\Auth\Contracts\LogoutHandlerInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Support\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly LoginHandlerInterface $loginHandler,
        private readonly LogoutHandlerInterface $logoutHandler,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $auth = $this->loginHandler->handle(LoginCommand::fromRequest($request));

        if (!$auth) {
            throw new AuthenticationException('Неверный email или пароль');
        }

        return ApiResponse::success(null);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->logoutHandler->handle($request);

        return ApiResponse::success(null);
    }

    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success(
            new UserResource($request->user())
        );
    }
}
