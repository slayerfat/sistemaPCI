<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\ViewVariable\Interfaces\ViewVariableInterface;
use Redirect;

/**
 * Class AbstractAuxController
 * @package PCI\Http\Controllers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractAuxController extends Controller
{

    /**
     * La fabrica que genera la vista para el usuario.
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
     * @param string $view la vista en texto entendible por el view factory.
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
     * Este es la logica basica que utilizan los controladores
     * dependientes de esta clase para eliminar
     * a un modelo de la base de datos.
     * @param boolean|\PCI\Models\AbstractBaseModel $model
     * @param string $alias el alias o descripcion del modelo.
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
