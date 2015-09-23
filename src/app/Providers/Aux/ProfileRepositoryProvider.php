<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Profile;
use PCI\Repositories\Aux\ProfileRepository;
use PCI\Repositories\Interfaces\Aux\ProfileRepositoryInterface;

class ProfileRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->registerProfileRepository();
    }

    /**
     * Registra el Repositorio de Perfil
     * @return void
     */
    private function registerProfileRepository()
    {
        $this->app->bind(ProfileRepositoryInterface::class, function ($app) {
            return new ProfileRepository($app[Profile::class]);
        });
    }
}
