<?php

namespace PCI\Providers\User;

use PCI\Models\User;
use PCI\Models\Employee;
use Illuminate\Support\ServiceProvider;
use PCI\Repositories\User\UserRepository;
use PCI\Repositories\User\EmployeeRepository;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;

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

        $this->app->bind(
            EmployeeRepositoryInterface::class,
            function ($app) {
                return new EmployeeRepository(
                    $app[Employee::class],
                    new UserRepository($app[User::class])
                );
            }
        );
    }
}
