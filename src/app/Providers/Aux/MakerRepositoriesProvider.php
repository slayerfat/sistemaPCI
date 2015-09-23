<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Maker;
use PCI\Repositories\Aux\MakerRepository;
use PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface;

class MakerRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->registerMaker();
    }

    /**
     * Registra el Repositorio de Fabricante
     * @return void
     */
    private function registerMaker()
    {
        $this->app->bind(MakerRepositoryInterface::class, function ($app) {
            return new MakerRepository($app[Maker::class]);
        });
    }
}
