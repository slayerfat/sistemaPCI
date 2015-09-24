<?php namespace PCI\Providers\Aux;

use Illuminate\Support\ServiceProvider;
use PCI\Models\ItemType;
use PCI\Models\MovementType;
use PCI\Models\NoteType;
use PCI\Models\PetitionType;
use PCI\Repositories\Aux\ItemTypesRepository;
use PCI\Repositories\Aux\MovementTypeRepository;
use PCI\Repositories\Aux\NoteTypeRepository;
use PCI\Repositories\Aux\PetitionTypeRepository;
use PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\MovementTypeRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\PetitionTypeRepositoryInterface;

/**
 * Class TypesRepositoriesProvider
 * @package PCI\Providers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class TypesRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->registerItemType();

        $this->registerMovementType();

        $this->registerNoteType();

        $this->registerPetitionType();
    }

    /**
     * Registra el Repositorio de Tipo de Item
     * @return void
     */
    private function registerItemType()
    {
        // estos repositorios tienen caracteristicas muy similares
        $this->app->bind(ItemTypesRepositoryInterface::class, function ($app) {
            return new ItemTypesRepository($app[ItemType::class]);
        });
    }

    /**
     * Registra el Repositorio de Tipo de Movimiento
     * @return void
     */
    private function registerMovementType()
    {
        // todos necesitan a su modelo
        $this->app->bind(MovementTypeRepositoryInterface::class, function ($app) {
            return new MovementTypeRepository($app[MovementType::class]);
        });
    }

    /**
     * Registra el Repositorio de Tipo de Nota
     * @return void
     */
    private function registerNoteType()
    {
        // y todos ejecutan practicamente la misma accion
        $this->app->bind(NoteTypeRepositoryInterface::class, function ($app) {
            return new NoteTypeRepository($app[NoteType::class]);
        });
    }

    /**
     * Registra el Repositorio de Tipo de Pedido
     * @return void
     */
    private function registerPetitionType()
    {
        // abstraer a un solo repositorio?
        $this->app->bind(PetitionTypeRepositoryInterface::class, function ($app) {
            return new PetitionTypeRepository($app[PetitionType::class]);
        });
    }
}
