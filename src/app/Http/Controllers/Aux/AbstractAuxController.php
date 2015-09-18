<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Repositories\ViewVariable\Interfaces\ViewVariableInterface;
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
     * @param string $view
     * @param \PCI\Repositories\ViewVariable\Interfaces\ViewVariableInterface $variables
     * @return \Illuminate\Contracts\View\View
     */
    protected function makeView($view, ViewVariableInterface $variables)
    {
        return $this->view->make($view, ['variables' => $variables]);
    }
}
