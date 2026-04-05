<?php

namespace App\Providers;

use App\Handlers\User\ChangePasswordUserHandler;
use App\Handlers\User\Contracts\ChangePasswordUserHandlerInterface;
use App\Handlers\User\Contracts\CreateUserHandlerInterface;
use App\Handlers\User\Contracts\DeleteUserHandlerInterface;
use App\Handlers\User\Contracts\GetUserHandlerInterface;
use App\Handlers\User\Contracts\GetUsersHandlerInterface;
use App\Handlers\User\Contracts\SyncUserPermissionsHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserAvatarHandlerInterface;
use App\Handlers\User\Contracts\UpdateUserHandlerInterface;
use App\Handlers\User\CreateUserHandler;
use App\Handlers\User\DeleteUserHandler;
use App\Handlers\User\GetUserHandler;
use App\Handlers\User\GetUsersHandler;
use App\Handlers\User\SyncPermissionsUserHandler;
use App\Handlers\User\UpdateAvatarUserHandler;
use App\Handlers\User\UpdateUserHandler;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** HANDLERS */
        $this->app->bind(GetUserHandlerInterface::class, GetUserHandler::class);
        $this->app->bind(GetUsersHandlerInterface::class, GetUsersHandler::class);
        $this->app->bind(CreateUserHandlerInterface::class, CreateUserHandler::class);
        $this->app->bind(UpdateUserHandlerInterface::class, UpdateUserHandler::class);
        $this->app->bind(UpdateUserAvatarHandlerInterface::class, UpdateAvatarUserHandler::class);
        $this->app->bind(ChangePasswordUserHandlerInterface::class, ChangePasswordUserHandler::class);
        $this->app->bind(DeleteUserHandlerInterface::class, DeleteUserHandler::class);
        $this->app->bind(SyncUserPermissionsHandlerInterface::class, SyncPermissionsUserHandler::class);

        /** REPOSITORIES */
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
