<?php

namespace PCI\Http\Controllers;

use Flash;
use Redirect;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{

    /**
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
