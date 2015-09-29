<?php namespace PCI\Http\Routes;

/**
 * Class ItemRoutes
 * @package PCI\Http\Routes
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemRoutes extends AbstractPciRoutes
{

    /**
     * Las rutas varias que el formato restful
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions' => [
                'prefix'     => 'almacenes',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Item\DepotsController',
                'as'       => 'depots',
                'resource' => '{depots}'
            ]
        ],
    ];

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
