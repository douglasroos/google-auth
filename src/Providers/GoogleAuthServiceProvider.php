<?php

namespace Bagisto\GoogleAuth\Providers;

use Bagisto\GoogleAuth\Console\Commands\ConfigureGoogle;
use Bagisto\GoogleAuth\Providers\EventServiceProvider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class GoogleAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/services.php',
            'services'
        );

        $this->commands([
            ConfigureGoogle::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
                
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'google-auth');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'google-auth');

        $this->publishes([
            __DIR__.'/../Resources/img' => public_path('vendor/google-auth'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../Resources/views/users' => resource_path('admin-themes/default/views/users'),
        ], 'google-auth');
    }
}
