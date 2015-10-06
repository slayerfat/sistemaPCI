<?php namespace PCI\Providers\User;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Petition;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use PCI\Repositories\User\PetitionRepository;

/**
 * Class PetitionRepositoryProvider
 * @package PCI\Providers\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(PetitionRepositoryInterface::class, function ($app) {
            return new PetitionRepository(
                $app[Petition::class],
                $app[ItemRepositoryInterface::class]
            );
        });
    }
}
