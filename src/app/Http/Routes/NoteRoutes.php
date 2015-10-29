<?php namespace PCI\Http\Routes;

/**
 * Class NoteRoutes
 *
 * @package PCI\Http\Routes
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteRoutes extends AbstractPciRoutes
{

    /**
     * Las rutas varias que el formato restful
     *
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions' => [
                'prefix'     => 'notas',
                'middleware' => 'auth',
            ],
            'rtDetails'     => [
                'uses'     => 'Note\NotesController',
                'as'       => 'notes',
                'resource' => '{notes}',
            ],
        ],
    ];

    /**
     * Las opciones para crear las rutas.
     *
     * @var array
     */
    protected $nonRestfulOptions = [
        [
            'method' => 'any',
            'url' => 'api/notas/pdf/{notes}',
            'data'   => [
                'uses' => 'Api\Note\NotesController@makeNewPdf',
                'as'   => 'api.notes.pdf',
            ],
        ],
        [
            'method' => 'POST',
            'url'    => 'api/notas/status/{id}',
            'data'   => [
                'uses' => 'Api\Note\NotesController@changeStatus',
                'as'   => 'api.notes.status',
            ],
        ],
        [
            'method' => 'any',
            'url' => 'api/movimientos/pdf/{movements}',
            'data'   => [
                'uses' => 'Api\Note\MovementsController@makeNewPdf',
                'as'   => 'api.movements.pdf',
            ],
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
