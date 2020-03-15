<?php

namespace App\Providers;

use Google_Client;
use Google_Service_YouTube;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('google', function() {
            return new Google_Client([
                'developer_key' => env('GOOGLE_DEVELOPE_KEY')
            ]);
        });

        $this->app->singleton('youtube', function() {
            return new Google_Service_Youtube($this->app['google']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh-tw');
    }
}
