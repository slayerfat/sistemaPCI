<?php

namespace PCI\Providers\User;

use Illuminate\Support\ServiceProvider;
use PCI\Models\User;
use PCI\Repositories\Interfaces\UserRepositoryInterface;
use PCI\Repositories\UserRepository;

class UsersRepositoriesServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new UserRepository($app[User::class]);
        });
    }
}
