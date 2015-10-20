<?php

namespace PCI\Http\Controllers\Api\Note;

use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\RespondsToChangeStatus;
use PCI\Http\Requests;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use Response;

/**
 * Class NotesController
 *
 * @package PCI\Http\Controllers\Api\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NotesController extends Controller
{

    use RespondsToChangeStatus;

    /**
     * La implementacion de este repositorio.
     *
     * @var \PCI\Repositories\Interfaces\Note\NoteRepositoryInterface
     */
    private $repo;

    /**
     * Genera una nueva instancia de este api.
     *
     * @param NoteRepositoryInterface $repo
     */
    public function __construct(NoteRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Genera un nuevo PDF relacionada con la nota.
     * TODO: implementar
     *
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeNewPdf($id)
    {
        return Response::json(['status' => $id]);
    }
}
