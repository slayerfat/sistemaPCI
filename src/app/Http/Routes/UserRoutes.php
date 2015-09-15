<?php namespace PCI\Http\Routes;

class UserRoutes extends PCIRoute
{

    /**
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions' => [
                'prefix' => 'usuarios',
            ],
            'rtDetails' => [
                'uses'     => 'User\UsersController',
                'as'       => 'users',
                'resource' => '{users}'
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
