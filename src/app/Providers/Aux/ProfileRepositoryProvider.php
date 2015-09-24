<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Profile;
use PCI\Repositories\Aux\ProfileRepository;
use PCI\Repositories\Interfaces\Aux\ProfileRepositoryInterface;

/**
 * Class ProfileRepositoryProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ProfileRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProfileRepositoryInterface::class, function ($app) {
            return new ProfileRepository($app[Profile::class]);
        });
    }
}
