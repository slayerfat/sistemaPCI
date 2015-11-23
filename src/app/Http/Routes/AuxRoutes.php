<?php namespace PCI\Http\Routes;

/**
 * Class AuxRoutes
 * @package PCI\Http\Routes
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class AuxRoutes extends AbstractPciRoutes
{

    /**
     * Las rutas varias que el formato restful
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions' => [
                'prefix'     => 'categorias',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\CategoryController',
                'as'       => 'cats',
                'resource' => '{cats}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'rubros',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\SubCategoriesController',
                'as'       => 'subCats',
                'resource' => '{subCats}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'generos',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\GendersController',
                'as'       => 'genders',
                'resource' => '{genders}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'departamentos',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\DepartmentsController',
                'as'       => 'depts',
                'resource' => '{depts}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'tipos-item',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\ItemTypesController',
                'as'       => 'itemTypes',
                'resource' => '{itemTypes}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'fabricantes',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\MakersController',
                'as'       => 'makers',
                'resource' => '{makers}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'nacionalidades',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\NationalitiesController',
                'as'       => 'nats',
                'resource' => '{nats}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'tipos-nota',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\NoteTypesController',
                'as'       => 'noteTypes',
                'resource' => '{noteTypes}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'tipos-pedido',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\PetitionTypesController',
                'as'       => 'petitionTypes',
                'resource' => '{petitionTypes}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'cargos',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\PositionsController',
                'as'       => 'positions',
                'resource' => '{positions}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'tipos-cantidad',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\StockTypesController',
                'as'       => 'stockTypes',
                'resource' => '{stockTypes}'
            ]
        ],
    ];

    /**
     * Las rutas varias que no encajan en el formato restful
     * @var array
     */
    protected $nonRestfulOptions = [];

    /**
     * Genera todas las rutas relacionadas con esta clase
     * @return void
     */
    public function execute()
    {
        $this->executePrototype(
            $this->restfulOptions,
            $this->nonRestfulOptions
        );
    }
}
