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
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::namespace($this->namespace)
                ->middleware('api')
                ->group(function () {
                    // rotas publicas
                    Route::namespace('Openeds')
                        ->group(base_path('routes/openeds.php'));

                    // rotas privadas
                    Route::namespace('Closeds')->group(function () {
                        Route::namespace('backoffice')
                            ->prefix('backoffice')
                            ->group(base_path('routes/closeds/backoffice/users.php'));

                        Route::namespace('erp')
                            ->prefix('erp')
                            ->group(base_path('routes/closeds/erp/financial.php'));
                    });
            });
        });
    }
}
