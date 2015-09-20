<?php namespace PCI\Repositories\ViewVariable;

use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Repositories\ViewVariable\Interfaces\GetPaginatorInterface;

class ViewPaginatorVariable extends AbstractViewVariable implements GetPaginatorInterface
{

    /**
     * El Modelo a manipular
     * @var \Illuminate\Pagination\LengthAwarePaginator
     */
    protected $model;

    /**
     * Genera una instancia de ViewModelVariable, que sirve para generar
     * formularios genericos de entidades secundarias.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @param string $resource
     */
    public function __construct(LengthAwarePaginator $paginator, $resource)
    {
        $this->setModel($paginator);

        $this->setDefaults($resource);
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @return void
     */
    public function setModel(LengthAwarePaginator $paginator)
    {
        $this->model = $paginator;
    }
}
