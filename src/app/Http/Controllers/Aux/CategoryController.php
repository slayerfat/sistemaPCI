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
        return $this->createPrototype($catRepo);
    }
}
