<?php namespace PCI\Http\Routes;

class MiscRoutes extends PCIRoute
{

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * Autenticacion de usuario
         */
        [
            'method'         => 'get',
            'url'            => 'sesion/iniciar',
            'data'           => [
                'uses'       => 'Auth\AuthController@getLogin',
                'as'         => 'auth.getLogin',
            ]
        ],

        [
            'method'         => 'post',
            'url'            => 'sesion/iniciar',
            'data'           => [
                'uses'       => 'Auth\AuthController@postLogin',
                'as'         => 'auth.postLogin',
            ]
        ],

        [
            'method'         => 'get',
            'url'            => 'sesion/terminar',
            'data'           => [
                'uses'       => 'Auth\AuthController@getLogout',
                'as'         => 'auth.getLogout',
            ]
        ],

        /**
         * Registro de usuario
         */
        [
            'method'         => 'get',
            'url'            => 'registrarse',
            'data'           => [
                'uses'       => 'Auth\AuthController@getRegister',
                'as'         => 'auth.getRegister',
            ]
        ],

        [
            'method'         => 'post',
            'url'            => 'registrarse',
            'data'           => [
                'uses'       => 'Auth\AuthController@postRegister',
                'as'         => 'auth.postRegister',
            ]
        ],

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