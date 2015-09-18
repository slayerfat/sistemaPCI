<?php namespace PCI\Http\Controllers\Aux;

use PCI\Http\Requests\Aux\CategoryRequest;
use PCI\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends AbstractAuxController
{

    /**
     * @param \PCI\Repositories\Interfaces\CategoryRepositoryInterface $catRepo
     * @return \Illuminate\Contracts\View\View
     */
    public function create(CategoryRepositoryInterface $catRepo)
    {
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        $results = $catRepo->getCreateViewVariables();

        return $this->createPrototype($results);
    }

    public function store(CategoryRequest $request)
    {
        return $request->all();
    }
}
