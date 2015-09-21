<?php namespace PCI\Http\Controllers\Aux;

use Redirect;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\CategoryRequest;
use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;

class CategoryController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface
     */
    private $catRepo;

    /**
     * @var \PCI\Models\Category
     */
    private $model;

    /**
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface $catRepo
     */
    public function __construct(Factory $view, CategoryRepositoryInterface $catRepo)
    {
        parent::__construct($view);

        $this->catRepo = $catRepo;
    }

    public function index()
    {
        return $this->makeView(
            'aux.index',
            $this->catRepo->getIndexViewVariables()
        );
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $variables = $this->catRepo->getShowViewVariables($id);

        $variables->setUsersGoal('Categorias en el sistema');

        return $this->makeView('aux.show', $variables);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->makeView('aux.create', $this->catRepo->getCreateViewVariables());
    }

    /**
     * @param \PCI\Http\Requests\Aux\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $this->model = $this->catRepo->create($request->all());

        return Redirect::route('cats.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->catRepo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.cats.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, CategoryRequest $request)
    {
        $this->model = $this->catRepo->update($id, $request->all());

        return Redirect::route('cats.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->destroyPrototype($this->catRepo->delete($id), 'cats');
    }
}
