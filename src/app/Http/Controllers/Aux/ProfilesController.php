<?php namespace PCI\Http\Controllers\Aux;

use Flash;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\ProfileRequest;
use PCI\Repositories\Interfaces\Aux\ProfileRepositoryInterface;
use Redirect;

class ProfilesController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\ProfileRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\Profile
     */
    private $model;

    /**
     * Este controlador necesita el repositorio de pefiles.
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\ProfileRepositoryInterface $repo
     */
    public function __construct(Factory $view, ProfileRepositoryInterface $repo)
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

        $variables->setUsersGoal('Pefiles en el sistema');

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
     * @param \PCI\Http\Requests\Aux\ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProfileRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        Flash::success(trans('models.profiles.store.success'));

        return Redirect::route('profiles.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.profiles.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, ProfileRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        Flash::success(trans('models.profiles.update.success'));

        return Redirect::route('profiles.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'profiles');
    }
}
