<?php namespace PCI\Http\Routes;

class MiscRoutes extends PCIRoute
{

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * usuario por verificar
         */
        [
            'method'         => 'get',
            'url'            => '/',
            'data'           => [
                'uses'       => 'IndexController@index',
                'as'         => 'index',
            ]
        ],
    ];

    /**
     * Genera todas las rutas relacionadas con esta clase
     */
    public function execute()
    {
        $this->executePrototype(
            $this->restfulOptions,
            $this->nonRestfulOptions
        );
    }
}
