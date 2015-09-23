<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Category;
use PCI\Models\SubCategory;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Aux\SubCategoryRepository;
use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface;

class CategoriesRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * Categorias, Rubros
     * @return void
     */
    public function register()
    {
        $this->registerCategory();

        $this->registerSubCategory();
    }

    /**
     * Registra el Repositorio de Rubros
     * @return void
     */
    private function registerCategory()
    {
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository($app[Category::class]);
        });
    }

    /**
     * Registra el Repositorio de Rubros
     * @return void
     */
    private function registerSubCategory()
    {
        $this->app->bind(SubCategoryRepositoryInterface::class, function ($app) {
            return new SubCategoryRepository($app[SubCategory::class]);
        });
    }
}
