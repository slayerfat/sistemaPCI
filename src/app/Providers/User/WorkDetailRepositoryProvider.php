<?php namespace PCI\Providers\User;

use Illuminate\Support\ServiceProvider;
use PCI\Models\WorkDetail;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface;
use PCI\Repositories\User\WorkDetailRepository;

class WorkDetailRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        // el repositorio necesita dos cosas para funcionar:
        // necesita al empleado y necesita al repo de usuario
        $this->app->bind(
            WorkDetailRepositoryInterface::class,
            // asi que cuando registramos el repo
            // debemos pasarle o crear estas instancias
            function ($app) {
                return new WorkDetailRepository(
                    $app[WorkDetail::class],
                    $app[EmployeeRepositoryInterface::class]
                );
            }
        );
    }
}
