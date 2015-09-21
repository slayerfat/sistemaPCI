<?php namespace PCI\Http\Controllers\Aux;

use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use Redirect;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\NoteTypeRequest;

class NoteTypesController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\NoteType
     */
    private $model;

    /**
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface $repo
     */
    public function __construct(Factory $view, NoteTypeRepositoryInterface $repo)
    {
        parent::__construct($view);

        $this->repo = $repo;
    }

    public function index()
    {
        return $this->makeView(
            'aux.index',
            $this->repo->getIndexViewVariables()
        );
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $variables = $this->repo->getShowViewVariables($id);

        $variables->setUsersGoal('Tipo de Notas en el sistema');

        return $this->makeView('aux.show', $variables);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        $results = $this->repo->getCreateViewVariables();

        return $this->makeView('aux.create', $results);
    }

    /**
     * @param \PCI\Http\Requests\Aux\NoteTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NoteTypeRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        return Redirect::route('noteTypes.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.noteTypes.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\NoteTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, NoteTypeRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        return Redirect::route('noteTypes.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->model = $this->repo->delete($id);

        if ($this->model === true) {
            return Redirect::route('noteTypes.index');
        }

        return Redirect::route('noteTypes.show', $this->model->desc);
    }
}
