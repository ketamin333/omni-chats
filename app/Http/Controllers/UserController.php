<?php

namespace App\Http\Controllers;

use App\Commands\User\ChangePasswordUserCommand;
use App\Commands\User\CreateUserCommand;
use App\Commands\User\DeleteUserCommand;
use App\Commands\User\UpdateAvatarUserCommand;
use App\Commands\User\UpdateUserCommand;
use App\Handlers\User\Contracts\ChangePasswordUserHandlerInterface;
use App\Handlers\User\Contracts\CreateUserHandlerInterface;
use App\Handlers\User\Contracts\DeleteUserHandlerInterface;
use App\Handlers\User\Contracts\GetUserHandlerInterface;
use App\Handlers\User\Contracts\GetUsersHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserAvatarHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserHandlerInterface;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Queries\User\GetUserQuery;
use App\Queries\User\GetUsersQuery;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly GetUsersHandlerInterface $getUsersHandler,
        private readonly GetUserHandlerInterface $getUserHandler,
        private readonly CreateUserHandlerInterface $createUserHandler,
        private readonly UpdateUserHandlerInterface $updateUserHandler,
        private readonly UpdateUserAvatarHandlerInterface $updateUserAvatarHandler,
        private readonly ChangePasswordUserHandlerInterface $changePasswordUserHandler,
        private readonly DeleteUserHandlerInterface $deleteUserHandler,
    ) {}

    public function index(IndexRequest $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = $this->getUsersHandler->handle(
            GetUsersQuery::fromRequest($request)
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

    public function store(StoreRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = $this->createUserHandler->handle(
            CreateUserCommand::fromRequest($request)
        );

        return ApiResponse::success(new UserResource($user));
    }

    public function update(UpdateRequest $request, int $userId): JsonResponse
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

    public function updateAvatar(UpdateAvatarRequest $request, int $userId): JsonResponse
    {
        $user = $this->getUserHandler->handle(
            new GetUserQuery($userId, $request->user()->company_id)
        );

        $this->authorize('update', $user);

        $user = $this->updateUserAvatarHandler->handle(
            UpdateAvatarUserCommand::fromRequest($request, $user)
        );

        return ApiResponse::success(new UserResource($user));
    }

    public function changePassword(ChangePasswordRequest $request, int $userId): Response
    {
        $user = $this->getUserHandler->handle(
            new GetUserQuery($userId, $request->user()->company_id)
        );

        $this->authorize('update', $user);

        $this->changePasswordUserHandler->handle(
            ChangePasswordUserCommand::fromRequest($request, $user)
        );

        return ApiResponse::noContent();
    }

    public function destroy(Request $request, int $userId): Response
    {
        $user = $this->getUserHandler->handle(
            new GetUserQuery($userId, $request->user()->company_id)
        );

        $this->authorize('delete', $user);

        $this->deleteUserHandler->handle(
            new DeleteUserCommand($user)
        );

        return ApiResponse::noContent();
    }
}
