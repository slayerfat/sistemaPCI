<?php namespace PCI\Http\Controllers\Traits\Api;

use Response;

/**
 * trait HasDefaultJsonMsg
 *
 * @package PCI\Http\Controllers\Traits\Api
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait HasDefaultJsonMsg
{

    /**
     * @param string $str
     * @param bool   $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonMsg($status, $str = 'Id necesario para continuar.')
    {
        return Response::json([
            'status' => $status,
            'message' => $str
        ]);
    }
}
