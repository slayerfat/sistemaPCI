<?php namespace PCI\Repositories\Interfaces\Misc;

interface FindParentInterface
{

    /**
     * @param string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function findParent($id);
}
