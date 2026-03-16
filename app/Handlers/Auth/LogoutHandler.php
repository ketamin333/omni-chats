<?php

namespace App\Handlers\Auth;

use App\Handlers\Auth\Contracts\LogoutHandlerInterface;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

class LogoutHandler implements LogoutHandlerInterface
{
    /**
     * Handles Logout action.
     */
    public function __construct(
        protected StatefulGuard $guard
    ) {}

    public function handle(Request $request): void
    {
        $this->guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
