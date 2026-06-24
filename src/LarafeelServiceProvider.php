<?php

namespace Yudafhd\Larafeel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class LarafeelServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/larafeel.php', 'larafeel');

        // Merge Larafeel configuration into Scramble's configuration
        $this->app->make('config')->set('scramble', array_replace_recursive(
            $this->app->make('config')->get('scramble', []),
            $this->app->make('config')->get('larafeel', [])
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load package views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'larafeel');

        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            // Allow publishing the Larafeel config
            $this->publishes([
                __DIR__.'/../config/larafeel.php' => config_path('larafeel.php'),
            ], 'larafeel-config');

            // Allow publishing pre-built assets to host application's public/ vendor folder
            $this->publishes([
                __DIR__.'/../resources/dist' => public_path('vendor/larafeel'),
            ], 'laravel-assets');
        }

        // Define a fallback for the viewApiDocs Gate if not already defined in the application
        if (!Gate::has('viewApiDocs')) {
            Gate::define('viewApiDocs', function ($user = null) {
                return true;
            });
        }
    }
}
