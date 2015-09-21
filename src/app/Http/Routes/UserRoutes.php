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
                'resource' => '{employees}'
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
