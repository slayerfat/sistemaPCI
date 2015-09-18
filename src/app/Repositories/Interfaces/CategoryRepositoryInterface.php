<?php namespace PCI\Repositories\Interfaces;

interface CategoryRepositoryInterface extends ModelRepositoryInterface, ViewableInterface
{

    /**
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getBySlugOrId($id);
}
