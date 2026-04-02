<?php

namespace App\Providers;

use App\Handlers\Permission\Contracts\GetPermissionsHandlerInterface;
use App\Handlers\Permission\GetPermissionsHandler;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\PermissionRepository;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** Обработчики */
        $this->app->bind(GetPermissionsHandlerInterface::class, GetPermissionsHandler::class);


        /** Репозиторий */
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
