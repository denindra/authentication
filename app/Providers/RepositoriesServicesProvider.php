<?php

namespace App\Providers;

use App\Interfaces\UsersAdminInterface;
use App\Interfaces\UsersInterface;
use App\Repositories\UsersAdminRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServicesProvider extends ServiceProvider
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
        $this->app->bind(UsersAdminInterface::class,UsersAdminRepository::class);
        $this->app->bind(UsersInterface::class,UsersRepository::class);
    }
}
