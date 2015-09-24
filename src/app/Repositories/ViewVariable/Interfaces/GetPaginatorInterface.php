<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface GetPaginatorInterface
{

    /**
     * Regresa el Paginador para ser manipulado por alguna vista.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getModel();

    /**
     * Guarda algun paginador.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @return void
     */
    public function setModel(LengthAwarePaginator $paginator);
}
