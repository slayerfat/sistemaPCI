<?php namespace PCI\Http\Requests\Aux;

use Illuminate\Auth\Guard;
use PCI\Http\Requests\Request;

abstract class AbstractAuxRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @param \Illuminate\Auth\Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return $auth->user()->isAdmin();
    }
}
