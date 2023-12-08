<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/item')
                ->group(base_path('routes/api/itens.php'));

            Route::middleware('api')
                ->prefix('api/produto')
                ->group(base_path('routes/api/produtos.php'));

            Route::middleware('api')
                ->prefix('api/mesa')
                ->group(base_path('routes/api/mesas.php'));

            Route::middleware('api')
                ->prefix('api/pedido')
                ->group(base_path('routes/api/pedidos.php'));

            // Route::middleware('web')
            //     ->group(base_path('routes/web.php'));
        });
    }
}
