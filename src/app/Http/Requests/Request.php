<?php

namespace PCI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

    /**
     * @see FormRequest.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        flash()->error(trans('defaults.auth.error'));

        return redirect()->back();
    }

    /**
     * si el metodo es POST, se esta creando un nuevo usuario
     * lo que implica que el middleware de admin tuvo que
     * ser activado antes de caer a este request.
     *
     * @return bool
     */
    protected function creating()
    {
        return $this->method() == 'POST';
    }
}
