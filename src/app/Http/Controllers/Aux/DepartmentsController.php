<?php namespace PCI\Http\Controllers\Aux;

use Flash;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\DepartmentRequest;
use PCI\Repositories\Interfaces\Aux\DepartmentRepositoryInterface;
use Redirect;

class DepartmentsController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\DepartmentRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\Department
     */
    private $model;

    /**
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\DepartmentRepositoryInterface $repo
     */
    public function __construct(Factory $view, DepartmentRepositoryInterface $repo)
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

        $variables->setUsersGoal('Departamentos en el sistema');

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
     * @param \PCI\Http\Requests\Aux\DepartmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DepartmentRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        Flash::success(trans('models.depts.store.success'));

        return Redirect::route('depts.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.depts.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\DepartmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, DepartmentRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        Flash::success(trans('models.depts.update.success'));

        return Redirect::route('depts.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'depts');
    }
}
