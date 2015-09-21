<?php namespace PCI\Providers\Aux;

use PCI\Models\Maker;
use PCI\Models\Gender;
use PCI\Models\Category;
use PCI\Models\ItemType;
use PCI\Models\NoteType;
use PCI\Models\Department;
use PCI\Models\MovementType;
use PCI\Models\Nationality;
use Illuminate\Support\ServiceProvider;
use PCI\Repositories\Aux\MakerRepository;
use PCI\Repositories\Aux\GenderRepository;
use PCI\Repositories\Aux\NoteTypeRepository;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Aux\ItemTypesRepository;
use PCI\Repositories\Aux\DepartmentRepository;
use PCI\Repositories\Aux\NationalityRepository;
use PCI\Repositories\Aux\MovementTypeRepository;
use PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\GenderRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\DepartmentRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\NationalityRepositoryInterface;
use PCI\Repositories\Interfaces\Aux\MovementTypeRepositoryInterface;

/** @SuppressWarnings(PHPMD.CouplingBetweenObjects) */

class AuxRepositoriesProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository($app[Category::class]);
        });

        $this->app->bind(DepartmentRepositoryInterface::class, function ($app) {
            return new DepartmentRepository($app[Department::class]);
        });

        $this->app->bind(GenderRepositoryInterface::class, function ($app) {
            return new GenderRepository($app[Gender::class]);
        });

        $this->app->bind(ItemTypesRepositoryInterface::class, function ($app) {
            return new ItemTypesRepository($app[ItemType::class]);
        });

        $this->app->bind(MakerRepositoryInterface::class, function ($app) {
            return new MakerRepository($app[Maker::class]);
        });

        $this->app->bind(MovementTypeRepositoryInterface::class, function ($app) {
            return new MovementTypeRepository($app[MovementType::class]);
        });

        $this->app->bind(NationalityRepositoryInterface::class, function ($app) {
            return new NationalityRepository($app[Nationality::class]);
        });

        $this->app->bind(NoteTypeRepositoryInterface::class, function ($app) {
            return new NoteTypeRepository($app[NoteType::class]);
        });
    }
}
