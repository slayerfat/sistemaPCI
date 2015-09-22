<?php

namespace PCI\Providers\User;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use PCI\Repositories\User\AddressRepository;
use PCI\Repositories\User\EmployeeRepository;
use PCI\Repositories\User\UserRepository;

class UsersRepositoriesServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
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
                    $app[UserRepositoryInterface::class]
                );
            }
        );

        $this->app->bind(AddressRepositoryInterface::class, function ($app) {
            return new AddressRepository(
                $app[Address::class],
                $app[EmployeeRepositoryInterface::class]
            );
        });
    }
}
