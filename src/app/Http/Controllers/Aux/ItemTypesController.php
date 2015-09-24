<?php namespace PCI\Http\Controllers\Aux;

use Flash;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\ItemTypeRequest;
use PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface;
use Redirect;

class ItemTypesController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\ItemType
     */
    private $model;

    /**
     * Este controlador necesita el repositorio de tipos de items.
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface $repo
     */
    public function __construct(Factory $view, ItemTypesRepositoryInterface $repo)
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

        $variables->setUsersGoal('Tipos de Item en el sistema');

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
     * @param \PCI\Http\Requests\Aux\ItemTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ItemTypeRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        Flash::success(trans('models.itemTypes.store.success'));

        return Redirect::route('itemTypes.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.itemTypes.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\ItemTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, ItemTypeRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        Flash::success(trans('models.itemTypes.update.success'));

        return Redirect::route('itemTypes.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'itemTypes');
    }
}
