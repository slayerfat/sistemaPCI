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
         * Validacion de confirmacion
         */
        [
            'method'         => 'get',
            'url'            => 'confirmar/crear',
            'data'           => [
                'uses'       => 'Auth\UserConfirmationController@create',
                'as'         => 'auth.confirm.create',
            ]
        ],
        [
            'method'         => 'get',
            'url'            => 'confirmar/{codigos}',
            'data'           => [
                'uses'       => 'Auth\UserConfirmationController@confirm',
                'as'         => 'auth.confirm',
            ]
        ],

        /**
         * Index/Home/Inicio
         */
        [
            'method'         => 'get',
            'url'            => '/',
            'data'           => [
                'uses'       => 'IndexController@index',
                'as'         => 'index',
                'middleware' => 'auth',
            ]
        ],
        [
            'method'         => 'get',
            'url'            => '/por-verificar',
            'data'           => [
                'uses'       => 'IndexController@disabled',
                'as'         => 'index.disabled',
                'middleware' => 'disabled',
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
