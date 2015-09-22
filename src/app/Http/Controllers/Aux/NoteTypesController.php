<?php namespace PCI\Http\Controllers\Aux;

use Flash;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\NoteTypeRequest;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use Redirect;

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
        return $this->makeView('aux.create', $this->repo->getCreateViewVariables());
    }

    /**
     * @param \PCI\Http\Requests\Aux\NoteTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NoteTypeRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        Flash::success(trans('models.noteTypes.create.success'));

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

        Flash::success(trans('models.noteTypes.update.success'));

        return Redirect::route('noteTypes.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'noteTypes');
    }
}
