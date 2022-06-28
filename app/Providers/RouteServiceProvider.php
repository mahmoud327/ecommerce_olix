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
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // api routes
            Route::prefix('api')
                ->middleware(['api', 'lang'])
                // ->namespace($this->namespace)
                ->group(base_path('routes/api/refactoring/v1.php'));
            // api routes
            Route::prefix('api')
                ->middleware(['api', 'lang'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api/api.php'));

            Route::prefix('api')
                ->middleware(['api', 'lang'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api/product.php'));

            Route::prefix('api')
                ->middleware(['api', 'lang'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api/user.php'));

            Route::prefix('api')
                ->middleware(['api', 'lang'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api/post.php'));

            Route::prefix('api')
                ->middleware(['api', 'lang'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api/organization.php'));


            // web routes
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/web.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/admin.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/category.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/product.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/organization.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/filter.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/service.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/user.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/post.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/advertisment.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/property.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/account.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web/marketer.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
