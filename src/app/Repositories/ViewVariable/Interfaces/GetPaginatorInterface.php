<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface GetPaginatorInterface
{

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getModel();

    /**
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     */
    public function setModel(LengthAwarePaginator $paginator);
}
