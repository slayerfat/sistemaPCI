<?php namespace PCI\Http\Controllers\Api\Note;

use PCI\Http\Controllers\Controller;
use Response;

/**
 * Class MovementsController
 *
 * @package PCI\Http\Controllers\Api\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class MovementsController extends Controller
{

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
