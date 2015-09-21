<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Repositories\ViewVariable\Interfaces\ViewVariableInterface;
use PCI\Http\Controllers\Controller;
use Redirect;

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
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        return $this->view->make($view, ['variables' => $variables]);
    }

    /**
     * @param boolean|\PCI\Models\AbstractBaseModel $model
     * @param $alias
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function destroyPrototype($model, $alias)
    {
        if ($model === true) {
            return Redirect::route("{$alias}.index");
        }

        return Redirect::route("{$alias}.show", $model->desc);
    }
}
