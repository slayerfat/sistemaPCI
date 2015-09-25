<?php

namespace PCI\Http\Controllers;

use Flash;
use Illuminate\Routing\Controller as BaseController;
use Redirect;

/**
 * Class Controller
 * @package PCI\Http\Controllers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class Controller extends BaseController
{

    /**
     * Redirecciona de vuelta a donde esta el usuario,
     * especificando un mensaje error en el proceso.
     * @param null $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBack($message = null)
    {
        $message = $message ? $message : trans('defaults.auth.error');

        Flash::error($message);

        return Redirect::back();
    }
}
