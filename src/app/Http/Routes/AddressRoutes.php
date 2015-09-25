<?php namespace PCI\Http\Routes;

/**.
 * Class AddressRoutes
 * @package PCI\Http\Routes
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class AddressRoutes extends AbstractPciRoutes
{

    /**
     * Las rutas varias que no encajan en el formato restful
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * Ajax de Direcciones
         */
        [
            'method' => 'get',
            'url'    => 'api/direcciones/estados',
            'data'   => [
                'uses'       => 'Api\Address\AddressesController@states',
                'as'         => 'api.states.index',
                'middleware' => 'auth',
            ]
        ],
        [
            'method' => 'get',
            'url'    => 'api/direcciones/estados/{states}/municipios',
            'data'   => [
                'uses'       => 'Api\Address\AddressesController@towns',
                'as'         => 'api.states.towns.index',
                'middleware' => 'auth',
            ]
        ],
        [
            'method' => 'get',
            'url'    => 'api/direcciones/municipios/{towns}',
            'data'   => [
                'uses'       => 'Api\Address\AddressesController@town',
                'as'         => 'api.towns.show',
                'middleware' => 'auth',
            ]
        ],
        [
            'method' => 'get',
            'url'    => 'api/direcciones/municipios/{towns}/parroquias',
            'data'   => [
                'uses'       => 'Api\Address\AddressesController@parishes',
                'as'         => 'api.towns.parishes.index',
                'middleware' => 'auth',
            ]
        ],
        [
            'method' => 'get',
            'url'    => 'api/direcciones/parroquias/{parishes}',
            'data'   => [
                'uses'       => 'Api\Address\AddressesController@parish',
                'as'         => 'api.parishes.show',
                'middleware' => 'auth',
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
