<?php namespace PCI\Http\Controllers\Aux;

use PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface;
use Redirect;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\SubCategoryRequest;

class SubCategoriesController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\SubCategory
     */
    private $model;

    /**
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface $repo
     */
    public function __construct(Factory $view, SubCategoryRepositoryInterface $repo)
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

        $variables->setUsersGoal('Rubros en el sistema');

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
     * @param \PCI\Http\Requests\Aux\SubCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SubCategoryRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        return Redirect::route('subCats.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.subCats.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\SubCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, SubCategoryRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        return Redirect::route('subCats.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->repo->delete($id), 'subCats');
    }
}
