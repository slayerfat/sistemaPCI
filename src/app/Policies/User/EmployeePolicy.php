<?php namespace PCI\Policies\User;

use Illuminate\Contracts\Auth\Guard;
use PCI\Models\Employee;
use PCI\Models\User;

class EmployeePolicy
{

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param \PCI\Models\User $user
     * @param string $employee
     * @return bool
     * @throws \LogicException
     */
    public function create(User $user, $employee)
    {
        if ($employee !== Employee::class) {
            throw new \LogicException;
        }

        if ($user->employee) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $this->auth->user()->id == $user->id;
    }

    /**
     * @param \PCI\Models\Employee $employee
     * @return bool
     */
    public function update(Employee $employee)
    {
        return $this->auth->user()->isOwnerOrAdmin($employee->user_id);
    }
}
