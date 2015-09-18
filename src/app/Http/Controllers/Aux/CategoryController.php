<?php namespace PCI\Http\Controllers\Aux;

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
        $results = $catRepo->getViewVariables();
        $results->setUsersGoal(trans('defaults.cats.create'));

        return $this->createPrototype($results);
    }
}
