<?php

use App\Support\ApiResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('webhooks')
                ->group(base_path('routes/webhooks.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), 422, $e->errors());
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return ApiResponse::error($e->getMessage(), 404);
        });

        $exceptions->render(function (ModelNotFoundException $e) {
            return ApiResponse::error('Not found', 404);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error($e->getMessage(), 401);
            }

            return redirect()->route('login');
        });

        $exceptions->render(function (AccessDeniedHttpException  $e) {
            return ApiResponse::error($e->getMessage(), 403);
        });
    })->create();
