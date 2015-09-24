<?php

namespace PCI\Providers\User;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Address;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\User\AddressRepository;

class AddressRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        // asi como el repositorio de empleado
        // debemos pasarle parametros adicionales
        // al constructor del repositorio de direccion.
        $this->app->bind(AddressRepositoryInterface::class, function ($app) {
            return new AddressRepository(
                $app[Address::class],
                $app[EmployeeRepositoryInterface::class]
            );
        });
    }
}
