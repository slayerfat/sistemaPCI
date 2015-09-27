<?php namespace PCI\Providers\Item;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Depot;
use PCI\Repositories\Interfaces\Item\DepotRepositoryInterface;
use PCI\Repositories\Item\DepotRepository;

/**
 * Class DepotRepositoryProvider
 * @package PCI\Providers\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(DepotRepositoryInterface::class, function ($app) {
            return new DepotRepository($app[Depot::class]);
        });
    }
}
