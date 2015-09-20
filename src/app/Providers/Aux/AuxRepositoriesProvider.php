<?php namespace PCI\Providers\Aux;

use PCI\Models\Gender;
use PCI\Models\Category;
use PCI\Models\Department;
use Illuminate\Support\ServiceProvider;
use PCI\Repositories\Aux\GendersRepository;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Aux\DepartmentRepository;
use PCI\Repositories\Interfaces\Aux\GendersRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\DepartmentRepositoryInterface;

class AuxRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository($app[Category::class]);
        });

        $this->app->bind(DepartmentRepositoryInterface::class, function ($app) {
            return new DepartmentRepository($app[Department::class]);
        });

        $this->app->bind(GendersRepositoryInterface::class, function ($app) {
            return new GendersRepository($app[Gender::class]);
        });
    }
}
