<?php namespace PCI\Policies\User;

use LogicException;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\User;

class AddressPolicy
{

    /**
     * @param \PCI\Models\User $user
     * @param \PCI\Models\Address $address
     * @param \PCI\Models\Employee $employee
     * @return bool
     */
    public function create(User $user, Address $address, Employee $employee)
    {
        if (!$address instanceof Address) {
            throw new LogicException;
        }

        if ($employee->address) {
            return false;
        }

        return $user->isOwnerOrAdmin($employee->user_id);
    }
}
