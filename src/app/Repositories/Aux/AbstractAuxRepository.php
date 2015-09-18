<?php namespace PCI\Repositories\Aux;

use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;
use PCI\Repositories\ViewVariable\ViewCollectionVariable;

abstract class AbstractAuxRepository extends AbstractRepository
{

    /**
     * Genera una instancia de ViewModelVariable
     * dandole una implementacion de AbstractBaseModel.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    protected function generateViewVariable(AbstractBaseModel $model, $resource)
    {
        return new ViewModelVariable($model, $resource);
    }

    /**
     * Genera una instancia de ViewCollectionVariable
     * con una colecion de modelos.
     * @param \Illuminate\Database\Eloquent\Collection $model
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    protected function generateViewCollectionVariable(Collection $model, $resource)
    {
        return new ViewCollectionVariable($model, $resource);
    }

    /**
     * Genera una instancia de ViewCollectionVariable
     * con una colecion de modelos.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    protected function generateViewPaginatorVariable(LengthAwarePaginator $paginator, $resource)
    {
        return new ViewPaginatorVariable($paginator, $resource);
    }
}
