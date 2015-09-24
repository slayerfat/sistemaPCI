<?php namespace PCI\Http\Controllers\Aux;

use Flash;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\MakerRequest;
use PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface;
use Redirect;

class MakersController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\Maker
     */
    private $model;

    /**
     * Este controlador necesita el repositorio de fabricantes.
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface $repo
     */
    public function __construct(Factory $view, MakerRepositoryInterface $repo)
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

        $variables->setUsersGoal('Fabricantes en el sistema');

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
     * @param \PCI\Http\Requests\Aux\MakerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MakerRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        Flash::success(trans('models.makers.store.success'));

        return Redirect::route('makers.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.makers.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\MakerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, MakerRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        Flash::success(trans('models.makers.update.success'));

        return Redirect::route('makers.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'makers');
    }
}
