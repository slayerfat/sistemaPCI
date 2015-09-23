<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Department;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use PCI\Repositories\Aux\DepartmentRepository;
use PCI\Repositories\Aux\GenderRepository;
use PCI\Repositories\Aux\NationalityRepository;
use PCI\Repositories\Interfaces\Aux\DepartmentRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\GenderRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\NationalityRepositoryInterface;

class EmployeeRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->registerDepartment();

        $this->registerGender();

        $this->registerNationality();
    }

    /**
     * Registra el Repositorio de Departamentos
     * @return void
     */
    private function registerDepartment()
    {
        $this->app->bind(DepartmentRepositoryInterface::class, function ($app) {
            return new DepartmentRepository($app[Department::class]);
        });
    }

    /**
     * Registra el Repositorio de Generos
     * @return void
     */
    private function registerGender()
    {
        $this->app->bind(GenderRepositoryInterface::class, function ($app) {
            return new GenderRepository($app[Gender::class]);
        });
    }

    /**
     * Registra el Repositorio de Nacionalidades
     * @return void
     */
    private function registerNationality()
    {
        $this->app->bind(NationalityRepositoryInterface::class, function ($app) {
            return new NationalityRepository($app[Nationality::class]);
        });
    }
}
