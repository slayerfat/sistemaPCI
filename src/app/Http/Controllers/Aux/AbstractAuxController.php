<?php namespace PCI\Http\Controllers\Aux;

use PCI\Http\Controllers\Controller;

abstract class AbstractAuxController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @method __construct
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
}
