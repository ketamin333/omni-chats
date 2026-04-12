<?php

namespace App\Http\Middleware\Webhooks;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTelegramBotWebhookSecret
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-Telegram-Bot-Api-Secret-Token') !== $request->route('channelTelegramBot')->credentials['secret_token']) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
