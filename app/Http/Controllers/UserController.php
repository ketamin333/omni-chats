<?php

namespace App\Http\Controllers;

use App\Commands\User\CreateUserCommand;
use App\Commands\User\GetUserCommand;
use App\Commands\User\GetUsersCommand;
use App\Handlers\User\Contracts\CreateUserHandlerInterface;
use App\Handlers\User\Contracts\DeleteUserHandlerInterface;
use App\Handlers\User\Contracts\GetUserHandlerInterface;
use App\Handlers\User\Contracts\GetUsersHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserHandlerInterface;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly GetUserHandlerInterface $getUserHandler,
        private readonly GetUsersHandlerInterface $getUsersHandler,
        private readonly CreateUserHandlerInterface $createUserHandler,
//        private readonly UpdateUserHandlerInterface $updateUserHandler,
//        private readonly DeleteUserHandlerInterface $deleteUserHandler,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = $this->getUsersHandler->handle(
            new GetUsersCommand($request->user()->company_id)
        );

        return ApiResponse::success($users);
    }

    public function show(Request $request, int $userId): JsonResponse
    {
        $user = $this->getUserHandler->handle(
            new GetUserCommand($userId, $request->user()->company_id)
        );

        $this->authorize('view', $user);

        return ApiResponse::success($user);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = $this->createUserHandler->handle(
            CreateUserCommand::fromRequest($request)
        );

        return ApiResponse::success($user);
    }

    public function update(UpdateRequest $request, User $user) {}
    public function destroy(User $user) {}
}
