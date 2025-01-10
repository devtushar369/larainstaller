<?php

namespace Hashcode\Larainstaller\Providers;

use Hashcode\Larainstaller\Middleware\InstallerMiddleware;
use Hashcode\Larainstaller\Middleware\IsInstalled;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LarainstallerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge default config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/larainstaller.php',
            'larainstaller'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Load Routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'larainstaller');

        // Publish Assets & Config File
        $this->publishes([
            __DIR__ . '/../config/larainstaller.php' => config_path('larainstaller.php'),
            __DIR__ . '/../Resources/assets' => public_path('vendor/larainstaller'),
        ], 'larainstaller');

        // Register Middleware
        $router = $this->app['router'];
        if (method_exists($router, 'middlewareGroup')) {
            $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
        }

    }
}
