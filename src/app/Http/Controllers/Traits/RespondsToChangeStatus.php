<?php namespace PCI\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Response;

/**
 * Trait RespondsToChangeStatus
 *
 * @package PCI\Http\Controllers\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property-read \PCI\Repositories\Note\NoteRepository $repo
 */
trait RespondsToChangeStatus
{

    /**
     * Cambia el estatus de algun modelo.
     *
     * @param int|string $id
     * @param Request    $request
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

    /**
     * Cambia el estatus de a nulo modelo.
     *
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeToNull($id)
    {
        /** @var \PCI\Models\Note $model */
        $model         = $this->repo->find($id);
        $model->status = null;
        $model->save();

        return $model;
    }

    /**
     * Chequea que el valor sea booleano o equivalente y regresa su valor
     *
     * @param $status
     * @return bool
     */
    public function parseStatus($status)
    {
        return filter_var($status, FILTER_VALIDATE_BOOLEAN);
    }
}
