<?php

namespace App\Handlers\Auth\Contracts;

use Illuminate\Http\Request;

interface LogoutHandlerInterface
{
    public function handle(Request $request): void;
}
