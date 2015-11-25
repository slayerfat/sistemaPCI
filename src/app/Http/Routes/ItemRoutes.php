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
            'url'  => 'api/tipos-cantidad',
            'data' => [
                'uses' => 'Api\Item\StockTypesController@index',
                'as'   => 'api.stockTypes.index',
            ]
        ],
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
        [
            'method' => 'get',
            'url'    => 'api/items/stock/{items}',
            'data'   => [
                'uses' => 'Api\Item\ItemsController@getStock',
                'as'   => 'api.items.stock',
            ]
        ],
        [
            'method' => 'get',
            'url'    => 'api/items/pdf/single/{items}',
            'data'   => [
                'uses' => 'Api\Item\ItemsController@singlePdf',
                'as'   => 'api.items.pdf.single',
            ],
        ],
        [
            'method' => 'get',
            'url'    => 'api/items/pdf/stock/{items}',
            'data'   => [
                'uses' => 'Api\Item\ItemsController@stockPdf',
                'as'   => 'api.items.pdf.stock',
            ],
        ],
        [
            'method' => 'get',
            'url'    => 'api/items/pdf/movements/{items}',
            'data'   => [
                'uses' => 'Api\Item\ItemsController@movementsPdf',
                'as'   => 'api.items.pdf.movements',
            ],
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
