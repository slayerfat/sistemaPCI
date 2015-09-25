<?php namespace PCI\Policies\User;

use LogicException;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\User;

/**
 * Class AddressPolicy
 * @package PCI\Policies\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class AddressPolicy
{

    /**
     * Chequea si el usuario que pretende crear una
     * direccion puede hacerlo en el sistema.
     * @param \PCI\Models\User $user El usuario que pretende manipular.
     * @param \PCI\Models\Address $address La direccion a manipular.
     * @param \PCI\Models\Employee $employee El padre que esta relacionado con direccion.
     * @return bool
     */
    public function create(User $user, Address $address, Employee $employee)
    {
        if (!$address instanceof Address) {
            throw new LogicException;
        }

        // el empleado solo puede tener una direccion.
        if ($employee->address) {
            return false;
        }

        // si no es administrador, solo el empleado
        // puede crear su direccion.
        return $user->isOwnerOrAdmin($employee->user_id);
    }
}
