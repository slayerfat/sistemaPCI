<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Category;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;

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
    }
}
