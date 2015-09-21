<?php namespace PCI\Http\Routes;

class UserRoutes extends AbstractPciRoutes
{

    /**
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
                'ignore'   => ['create']
            ]
        ],
    ];

    /**
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
