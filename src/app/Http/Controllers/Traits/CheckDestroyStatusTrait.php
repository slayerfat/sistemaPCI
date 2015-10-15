<?php namespace PCI\Http\Controllers\Traits;

use Redirect;

/**
 * Trait CheckDestroyStatusTrait
 * @package PCI\Http\Controllers\Traits
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
trait CheckDestroyStatusTrait
{

    /**
     * Chequea si los resultados fueron verdaderos (true) o falso (modelo) y redirecciona adecuadamente.
     *
     * @param boolean|\PCI\Models\AbstractBaseModel $result el modelo.
     * @param string                                $resource el recurso, users, items, etc.
     * @param null                                  $message si hay mensaje, se genera un flash.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkDestroyStatus($result, $resource, $message = null)
    {
        // este algoritmo basicamente se repite
        // en casi todos los controladores.
        if ($result === true) {
            return Redirect::route("{$resource}.index");
        }

        if ($message) {
            flash()->error($message);
        }

        return Redirect::route("{$resource}.show", $result->name);
    }
}
