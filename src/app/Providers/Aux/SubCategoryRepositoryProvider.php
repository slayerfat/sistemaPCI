<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\SubCategory;
use PCI\Repositories\Aux\SubCategoryRepository;
use PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface;

/**
 * Class SubCategoryRepositoryProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
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
