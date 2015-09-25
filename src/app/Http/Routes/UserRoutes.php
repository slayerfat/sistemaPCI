<?php namespace PCI\Http\Routes;

/**
 * Class UserRoutes
 * @package PCI\Http\Routes
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UserRoutes extends AbstractPciRoutes
{

    /**
     * Las rutas varias que encajan en el formato restful
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions' => [
                'prefix'     => 'usuarios',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'User\UsersController',
                'as'       => 'users',
                'resource' => '{users}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'perfiles',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Aux\ProfilesController',
                'as'       => 'profiles',
                'resource' => '{profiles}'
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'informacion-personal',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'User\EmployeesController',
                'as'       => 'employees',
                'resource' => '{employees}',
                'ignore'   => [
                    'create',
                    'store',
                    'index',
                    'show',
                    'destroy'
                ]
            ]
        ],
        [
            'routerOptions' => [
                'prefix'     => 'direcciones',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'User\AddressesController',
                'as'       => 'addresses',
                'resource' => '{addresses}',
                'ignore'   => [
                    'create',
                    'store',
                    'index',
                    'show',
                    'destroy'
                ]
            ]
        ],
    ];

    /**
     * Las rutas varias que no encajan en el formato restful
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * Employee create
         * se hace asi porque se necesita el id o nombre
         * del usuario asociado a este elemento.
         */
        [
            'method' => 'get',
            'url'    => 'informacion-personal/{users}/crear',
            'data'   => [
                'uses' => 'User\EmployeesController@create',
                'as'   => 'employees.create',
                'middleware' => 'auth'
            ]
        ],
        [
            'method' => 'post',
            'url'    => 'informacion-personal/{users}',
            'data'   => [
                'uses' => 'User\EmployeesController@store',
                'as'   => 'employees.store',
                'middleware' => 'auth'
            ]
        ],
        /**
         * Direccion, mismo caso que lo atenrior
         */
        [
            'method' => 'get',
            'url'    => 'direcciones/{employees}/crear',
            'data'   => [
                'uses'       => 'User\AddressesController@create',
                'as'         => 'addresses.create',
                'middleware' => 'auth'
            ]
        ],
        [
            'method' => 'post',
            'url'    => 'direcciones/{employees}',
            'data'   => [
                'uses' => 'User\AddressesController@store',
                'as'   => 'addresses.store',
                'middleware' => 'auth'
            ]
        ],
    ];

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
