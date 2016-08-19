<?php

namespace RummyKhan\XLog;

use Illuminate\Support\ServiceProvider;

class XLogServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->publishes([
            __DIR__ . '/config/xlog.php' => config_path('xlog.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/migrations/' => base_path('/database/migrations')
        ], 'migrations');


        $this->loadViewsFrom(__DIR__.'/views', 'xlog');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/xlog'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

}