<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\CategoryRepositoryInterface;

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
     *
     * @param \PCI\Repositories\Interfaces\CategoryRepositoryInterface $model
     * @return \Illuminate\Contracts\View\View
     */
    protected function createPrototype(CategoryRepositoryInterface $model)
    {
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        $variables = [];

        $results = $model->viewVariables();

        /**
         * el nombre que se le dara al modelo para
         * alguna vista en particular.
         * ej: 'mech => new MechanicalInfo',
         * lo que implica:
         * $variables['mech'] (instancia de MechanicalInfo)
         */
        $variables[$results['variableName']] = $model;

        return $this->view->make($results['target'] . 'create')->with($variables);
    }
}
