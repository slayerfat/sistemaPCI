<?php namespace PCI\Repositories\Interfaces;

interface RepositoryPaginatorInterface
{

    /**
     * @param int $quantity
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTablePaginator($quantity = 25);
}
