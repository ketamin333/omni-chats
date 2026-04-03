<?php

namespace App\Http\Controllers;

use App\Commands\User\CreateUserCommand;
use App\Commands\User\DeleteUserCommand;
use App\Commands\User\UpdateUserCommand;
use App\Handlers\User\Contracts\CreateUserHandlerInterface;
use App\Handlers\User\Contracts\DeleteUserHandlerInterface;
use App\Handlers\User\Contracts\GetUserHandlerInterface;
use App\Handlers\User\Contracts\GetUsersHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserHandlerInterface;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Queries\User\GetUserQuery;
use App\Queries\User\GetUsersQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly GetUsersHandlerInterface $getUsersHandler,
        private readonly GetUserHandlerInterface $getUserHandler,
        private readonly CreateUserHandlerInterface $createUserHandler,
        private readonly UpdateUserHandlerInterface $updateUserHandler,
        private readonly DeleteUserHandlerInterface $deleteUserHandler,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = $this->getUsersHandler->handle(
            new GetUsersQuery($request->user()->company_id)
        );

        return ApiResponse::paginated($users, UserListResource::class);
    }

    public function show(Request $request, int $userId): JsonResponse
    {
        $user = $this->getUserHandler->handle(
            new GetUserQuery($userId, $request->user()->company_id)
        );

        $this->authorize('view', $user);

        return ApiResponse::success(new UserResource($user));
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = $this->createUserHandler->handle(
            CreateUserCommand::fromRequest($request)
        );

        return ApiResponse::success(new UserResource($user));
    }

    public function update(UserUpdateRequest $request, int $userId): JsonResponse
    {
        $user = $this->getUserHandler->handle(
            new GetUserQuery($userId, $request->user()->company_id)
        );

        $this->authorize('update', $user);

        $user = $this->updateUserHandler->handle(
            UpdateUserCommand::fromRequest($request, $user)
        );

        return ApiResponse::success(new UserResource($user));
    }

    public function destroy(Request $request, int $userId): JsonResponse
    {
        $user = $this->getUserHandler->handle(
            new GetUserQuery($userId, $request->user()->company_id)
        );

        $this->authorize('delete', $user);

        $this->deleteUserHandler->handle(
            new DeleteUserCommand($user)
        );

        return ApiResponse::success(null, 204);
    }
}
