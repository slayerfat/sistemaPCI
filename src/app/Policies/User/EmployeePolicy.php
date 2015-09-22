<?php namespace PCI\Policies\User;

use Illuminate\Contracts\Auth\Guard;
use PCI\Models\Employee;
use PCI\Models\User;

class EmployeePolicy
{

    /**
     * @var \PCI\Models\User
     */
    private $user;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    /**
     * @param \PCI\Models\User $user
     * @param string $employee
     * @param \PCI\Models\User $relatedEmployeeUser
     * @return bool
     * @throws \LogicException
     */
    public function create(User $user, $employee, User $relatedEmployeeUser)
    {
        if (!($employee == Employee::class || $employee instanceof Employee)) {
            throw new \LogicException;
        }

        if ($relatedEmployeeUser->employee) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $this->user->id == $relatedEmployeeUser->id;
    }

    /**
     * @param \PCI\Models\Employee $employee
     * @return bool
     */
    public function update(Employee $employee)
    {
        return $this->user->isOwnerOrAdmin($employee->user_id);
    }
}
