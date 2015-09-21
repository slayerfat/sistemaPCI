<?php namespace PCI\Repositories\Interfaces\User;

use PCI\Repositories\Interfaces\ModelRepositoryInterface;

interface EmployeeRepositoryInterface extends ModelRepositoryInterface
{

    /**
     * @param string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function findUser($id);
}
