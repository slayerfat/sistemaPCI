<?php namespace PCI\Http\Controllers\Aux;

use Flash;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\NoteTypeRequest;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use Redirect;

/**
 * Class NoteTypesController
 * @package PCI\Http\Controllers\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteTypesController extends AbstractAuxController
{

    /**
     * La implementacion de la interfaz de repositorio.
     * @var \PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface
     */
    private $repo;

    /**
     * El modelo Eloquent.
     * @var \PCI\Models\NoteType
     */
    private $model;

    /**
     * Este controlador necesita el repositorio de tipo de notas.
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface $repo
     */
    public function __construct(Factory $view, NoteTypeRepositoryInterface $repo)
    {
        parent::__construct($view);

        $this->repo = $repo;
    }

    /**
     * Muestra un listado general del recurso.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->makeView(
            'aux.index',
            $this->repo->getIndexViewVariables()
        );
    }

    /**
     * Muestra el recurso especificado.
     * @param string|int $id El identificador unico.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $variables = $this->repo->getShowViewVariables($id);

        $variables->setUsersGoal('Tipo de Notas en el sistema');

        return $this->makeView('aux.show', $variables);
    }

    /**
     * Muestra la forma para crear un nuevo recurso.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->makeView('aux.create', $this->repo->getCreateViewVariables());
    }

    /**
     * Persiste la informacion relacionada con el nuevo recurso.
     * @param \PCI\Http\Requests\Aux\NoteTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NoteTypeRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        Flash::success(trans('models.noteTypes.store.success'));

        return Redirect::route('noteTypes.show', $this->model->slug);
    }

    /**
     * Muestra el forumulario para actualizar el recurso.
     * @param string|int $id El identificador unico.
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.noteTypes.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * Persiste la actualizacion del modelo.
     * @param int $id El identificador unico.
     * @param \PCI\Http\Requests\Aux\NoteTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, NoteTypeRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        Flash::success(trans('models.noteTypes.update.success'));

        return Redirect::route('noteTypes.show', $this->model->slug);
    }

    /**
     * Elimina al recurso del sistema
     * @param int $id El identificador unico.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'noteTypes');
    }
}
