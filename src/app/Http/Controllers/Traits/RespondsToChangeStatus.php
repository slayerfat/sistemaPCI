<?php namespace PCI\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Response;

/**
 * Trait RespondsToChangeStatus
 *
 * @package PCI\Http\Controllers\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait RespondsToChangeStatus
{

    /**
     * Cambia el estatus de algun modelo.
     *
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus($id, Request $request)
    {
        if (!$request->exists('status')) {
            return Response::json(['status' => false]);
        }

        $results = $this->repo->changeStatus($id, $request->input('status'));

        return Response::json(['status' => $results]);
    }
}
