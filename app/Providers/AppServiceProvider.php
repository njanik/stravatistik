<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->singleton('API', function ($app) {
            $api = new \Iamstuartwilson\StravaApi(
                config('app.stravatistik.client_id'),
                config('app.stravatistik.client_secret')
            );
            return $api;
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
