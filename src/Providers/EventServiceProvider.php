<?php

namespace Bagisto\GoogleAuth\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->app->make('events')->listen(
            SocialiteWasCalled::class,
            \SocialiteProviders\Google\GoogleExtendSocialite::class.'@handle'
        );
    }
}
