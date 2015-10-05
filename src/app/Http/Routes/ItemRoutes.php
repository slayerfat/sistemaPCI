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
        [
            'routerOptions' => [
                'prefix'     => 'items',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Item\ItemsController',
                'as'       => 'items',
                'resource' => '{items}'
            ]
        ],
    ];

    /**
     * Las opciones para crear las rutas.
     * @var array
     */
    protected $nonRestfulOptions = [
        [
            'method' => 'get',
            'url'    => 'api/items',
            'data'   => [
                'uses' => 'Api\Item\ItemsController@index',
                'as'   => 'api.items.index',
            ]
        ],
        [
            'method' => 'get',
            'url'    => 'api/items/search/{term}',
            'data'   => [
                'uses' => 'Api\Item\ItemsController@indexWithTerm',
                'as'   => 'api.items.indexTerm',
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
