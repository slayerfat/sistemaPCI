<?php namespace PCI\Policies\User;

use PCI\Models\Employee;
use PCI\Models\User;

/**
 * Class EmployeePolicy
 * @package PCI\Policies\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmployeePolicy
{

    /**
     * Se chequea si el empleado puede ser creado por
     * el usuario actualmente haciendo la peticion.
     * @param \PCI\Models\User $user El usuario haciendo la peticion.
     * @param \PCI\Models\Employee $employee El Empleado a manipular.
     * @param \PCI\Models\User $relatedEmployeeUser El modelo relacionado con el empleado.
     * @return bool
     */
    public function create(User $user, Employee $employee, User $relatedEmployeeUser)
    {
        if (!$employee instanceof Employee) {
            throw new \LogicException;
        }

        // el usuario solo puede tener una
        // informacion de empleado.
        if ($relatedEmployeeUser->employee) {
            return false;
        }

        // si no es administrador, solo el usuario puede
        // crear su propia informacion personal.
        return $user->isOwnerOrAdmin($relatedEmployeeUser->id);
    }

    /**
     * Se chequea si el empleado puede ser actualizado por
     * el usuario actualmente haciendo la peticion.
     * @param \PCI\Models\User $user El usuario haciendo la peticion.
     * @param \PCI\Models\Employee $employee El empleado a manipular.
     * @return bool
     */
    public function update(User $user, Employee $employee)
    {
        return $user->isOwnerOrAdmin($employee->user_id);
    }
}
