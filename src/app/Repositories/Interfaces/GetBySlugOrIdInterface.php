<?php namespace PCI\Repositories\Interfaces;

interface GetBySlugOrIdInterface
{

    /**
     * @param  string|int $id
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getBySlugOrId($id);
}
