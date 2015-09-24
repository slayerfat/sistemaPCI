<?php namespace PCI\Repositories\ViewVariable;

use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Repositories\ViewVariable\Interfaces\GetPaginatorInterface;

/**
 * Class ViewPaginatorVariable
 * @package PCI\Repositories\ViewVariable
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
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
     * @param string $resource La clase ::class a relacionar con el paginador.
     */
    public function __construct(LengthAwarePaginator $paginator, $resource)
    {
        $this->setModel($paginator);

        $this->setDefaults($resource);
    }

    /**
     * Regresa el Paginador para ser manipulado por alguna vista.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Guarda algun paginador.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @return void
     */
    public function setModel(LengthAwarePaginator $paginator)
    {
        $this->model = $paginator;
    }
}
