<?php

namespace App\Providers;

use App\Http\Controllers\BaseController;
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
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

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
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        RateLimiter::for('account-email-verification', function (Request $request) {

            return Limit::perMinute(1)->by($request->header('Authorization'))->response(function (){
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan sudah melewati batas, silahkan coba kembali dalam 1 menit kemudian',
                ], 429);

            });

        });


        RateLimiter::for('authentication', function (Request $request) {

            return Limit::perMinute(5)->by($request->ip())->response(function (){
                return response()->json([
                    'success' => false,
                    'message' => 'Login sudah melewati  batas, silahkan coba  beberapa  menit kemudian',
                ], 429);

            });

        });


    }
}
