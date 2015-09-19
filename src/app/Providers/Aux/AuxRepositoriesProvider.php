<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Category;
use PCI\Models\Department;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Aux\DepartmentRepository;
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
    }
}
