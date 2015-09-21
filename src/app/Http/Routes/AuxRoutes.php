<?php namespace PCI\Http\Routes;

class AuxRoutes extends AbstractPciRoutes
{

    /**
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
                'prefix'     => 'tipos-movimiento',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\MovementTypesController',
                'as'       => 'movementTypes',
                'resource' => '{movementTypes}'
            ]
        ],
    ];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [];

    /**
     * Genera todas las rutas relacionadas con esta clase
     *
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
