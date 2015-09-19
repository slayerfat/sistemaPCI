<?php

namespace PCI\Providers\User;

use PCI\Models\User;
use PCI\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;

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
