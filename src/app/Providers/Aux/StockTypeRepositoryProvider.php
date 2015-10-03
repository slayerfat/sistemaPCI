<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\StockType;
use PCI\Repositories\Aux\StockTypeRepository;
use PCI\Repositories\Interfaces\Aux\StockTypeRepositoryInterface;

/**
 * Class StockTypeRepositoryProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTypeRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(StockTypeRepositoryInterface::class, function ($app) {
            return new StockTypeRepository($app[StockType::class]);
        });
    }
}
