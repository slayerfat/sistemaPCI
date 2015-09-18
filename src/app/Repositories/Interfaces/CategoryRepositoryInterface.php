<?php namespace PCI\Repositories\Interfaces;

interface CategoryRepositoryInterface extends ModelRepositoryInterface, ViewableInterface
{

    /**
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariables
     */
    public function getBySlugOrId($id);
}
