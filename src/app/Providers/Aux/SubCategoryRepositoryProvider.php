<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\SubCategory;
use PCI\Repositories\Aux\SubCategoryRepository;
use PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface;

class SubCategoryRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * Rubros
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubCategoryRepositoryInterface::class, function ($app) {
            return new SubCategoryRepository($app[SubCategory::class]);
        });
    }
}
