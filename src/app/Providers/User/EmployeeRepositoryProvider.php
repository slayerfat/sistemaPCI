<?php

namespace PCI\Providers\User;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Employee;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use PCI\Repositories\User\EmployeeRepository;

class EmployeeRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->registerEmployee();
    }

    /**
     * Registra el Repositorio de Empleado
     * @return void
     */
    private function registerEmployee()
    {
        // el repositorio necesita dos cosas para funcionar:
        // necesita al empleado y necesita al repo de usuario
        $this->app->bind(
            EmployeeRepositoryInterface::class,
            // asi que cuando registramos el repo
            // debemos pasarle o crear estas instancias
            function ($app) {
                return new EmployeeRepository(
                    $app[Employee::class],
                    $app[UserRepositoryInterface::class]
                );
            }
        );
    }
}
