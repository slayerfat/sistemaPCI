<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Maker;
use PCI\Repositories\Aux\MakerRepository;
use PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface;

/**
 * Class MakerRepositoriesProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class MakerRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(MakerRepositoryInterface::class, function ($app) {
            return new MakerRepository($app[Maker::class]);
        });
    }
}
