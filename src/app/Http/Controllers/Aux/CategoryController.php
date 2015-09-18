<?php namespace PCI\Http\Controllers\Aux;

use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\CategoryRequest;
use PCI\Repositories\Interfaces\CategoryRepositoryInterface;
use Redirect;

class CategoryController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\CategoryRepositoryInterface
     */
    private $catRepo;

    /**
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\CategoryRepositoryInterface $catRepo
     */
    public function __construct(Factory $view, CategoryRepositoryInterface $catRepo)
    {
        parent::__construct($view);

        $this->catRepo = $catRepo;
    }

    public function show($id)
    {
        return $this->catRepo->find($id);
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

        return $this->createPrototype($results);
    }

    /**
     * @param \PCI\Http\Requests\Aux\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $cat = $this->catRepo->create($request->all());

        return Redirect::route('cats.show', $cat->id);
    }
}
