<?php

namespace App\Providers;

use App\Helpers\ApiResponse;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('api.response', function () {
            return new ApiResponse();
        });
    }
}
