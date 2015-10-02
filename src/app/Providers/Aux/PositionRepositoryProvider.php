<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Position;
use PCI\Repositories\Aux\PositionRepository;
use PCI\Repositories\Interfaces\Aux\PositionRepositoryInterface;

/**
 * Class PositionRepositoryProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PositionRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(PositionRepositoryInterface::class, function ($app) {
            return new PositionRepository($app[Position::class]);
        });
    }
}
