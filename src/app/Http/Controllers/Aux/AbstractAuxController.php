<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\ViewableInterface;

abstract class AbstractAuxController extends Controller
{

    /**
     * @var \Illuminate\View\Factory
     */
    private $view;

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
     * @param \PCI\Repositories\Interfaces\ViewableInterface $repo
     * @return \Illuminate\Contracts\View\View
     */
    protected function createPrototype(ViewableInterface $repo)
    {
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        $results = $repo->getViewVariables();

        return $this->view->make(
            $results->getViewName() . 'create',
            ['model' => $results->getModel()]
        );
    }
}
