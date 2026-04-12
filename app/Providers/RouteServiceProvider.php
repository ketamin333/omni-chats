<?php

namespace App\Providers;

use App\Enums\AdapterName;
use App\Enums\AdapterType;
use App\Models\Channel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /** RATE LIMITER */
        $this->rateLimiters();
        $this->bindings();
    }

    private function rateLimiters(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinutes(5, 5)->by($request->email);
        });
    }

    private function bindings(): void
    {
        Route::bind('channelTelegramBot', fn ($value) =>
        Channel::where('credentials->bot_id', $value)
            ->whereHas('adapter', fn ($q) => $q
                ->where('adapter_name', AdapterName::TELEGRAM)
                ->where('adapter_type', AdapterType::BOT)
            )->firstOrFail()
        );
    }
}
