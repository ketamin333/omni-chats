<?php

namespace App\Providers;

use App\Enums\PermissionSlug;
use App\Handlers\Auth\Contracts\LoginHandlerInterface;
use App\Handlers\Auth\Contracts\LogoutHandlerInterface;
use App\Handlers\Auth\LoginHandler;
use App\Handlers\Auth\LogoutHandler;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StatefulGuard::class, fn() => Auth::guard('web'));
        $this->app->bind(LoginHandlerInterface::class, LoginHandler::class);
        $this->app->bind(LogoutHandlerInterface::class, LogoutHandler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, PermissionSlug|string $slug) {
            return $user->hasPermission($slug) ?: null;
        });
    }
}
