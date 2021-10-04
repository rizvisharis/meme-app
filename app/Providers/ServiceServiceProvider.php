<?php

namespace App\Providers;

use App\Services\AuthenticateService;
use App\Services\ImageUploadService;
use App\Services\Interfaces\AuthenticateServiceInterface;
use App\Services\Interfaces\ImageUploadServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthenticateServiceInterface::class, AuthenticateService::class);
        $this->app->bind(ImageUploadServiceInterface::class, ImageUploadService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
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
