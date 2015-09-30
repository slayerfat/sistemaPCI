<?php namespace PCI\Providers\Item;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Item;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;
use PCI\Repositories\Item\ItemRepository;

/**
 * Class ItemRepositoryProvider
 * @package PCI\Providers\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(ItemRepositoryInterface::class, function ($app) {
            return new ItemRepository($app[Item::class]);
        });
    }
}
