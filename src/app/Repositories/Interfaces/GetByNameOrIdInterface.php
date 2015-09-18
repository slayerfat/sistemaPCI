<?php namespace PCI\Repositories\Interfaces;

interface GetByNameOrIdInterface
{

    /**
     * @param  string|int $id
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getByNameOrId($id);
}
