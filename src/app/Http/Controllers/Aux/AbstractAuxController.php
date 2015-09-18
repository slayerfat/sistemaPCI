<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use PCI\Http\Controllers\Controller;

abstract class AbstractAuxController extends Controller
{

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * Create a new controller instance.
     * @method __construct
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(Factory $view)
    {
        $this->middleware('admin');
        $this->view = $view;
    }

    /**
     * Genera una vista para ser utilizada por algun
     * otro controlador concreto.
     * @param \PCI\Repositories\ViewVariable\ViewModelVariable $variables
     * @return \Illuminate\Contracts\View\View
     */
    protected function showPrototype(ViewModelVariable $variables)
    {
        return $this->view->make(
            'aux.show',
            ['variables' => $variables]
        );
    }

    /**
     * Genera una vista para ser utilizada por algun
     * otro controlador concreto.
     * @param \PCI\Repositories\ViewVariable\ViewModelVariable $variables
     * @return \Illuminate\Contracts\View\View
     */
    protected function createPrototype(ViewModelVariable $variables)
    {
        return $this->view->make(
            'aux.create',
            ['variables' => $variables]
        );
    }
}
