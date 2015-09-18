<?php namespace PCI\Repositories\Interfaces;

interface CategoryRepositoryInterface extends ModelRepositoryInterface, ViewableInterface
{

    /**
     * @param mixed $id
     * @return \PCI\Models\Category
     */
    public function getBySlugOrId($id);
}
