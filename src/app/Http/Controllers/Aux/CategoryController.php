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
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        $results = $this->catRepo->getCreateViewVariables();

        return $this->makeView('aux.create', $results);
    }

    /**
     * @param \PCI\Http\Requests\Aux\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $cat = $this->catRepo->create($request->all());

        return Redirect::route('cats.show', $cat->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->catRepo->getEditViewVariables($id);

        $variables->setUsersGoal('Actualizar Categoria');

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, CategoryRequest $request)
    {
        $cat = $this->catRepo->update($id, $request->all());

        return Redirect::route('cats.show', $cat->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = $this->catRepo->delete($id);

        if ($result === true) {
            return Redirect::route('cats.index');
        }

        return Redirect::route('cats.show', $result->desc);
    }
}
