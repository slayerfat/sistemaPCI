<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Category;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;

/**
 * Class CategoryRepositoryProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class CategoryRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * Categorias
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository($app[Category::class]);
        });
    }
}
