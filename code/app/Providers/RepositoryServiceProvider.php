<?php

namespace App\Providers;

use App\Repositories\DeviceRepository;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
