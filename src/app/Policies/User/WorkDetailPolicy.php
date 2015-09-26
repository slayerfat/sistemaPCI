<?php namespace PCI\Policies\User;

use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Models\WorkDetail;

/**
 * Class WorkDetailPolicy
 * @package PCI\Policies\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class WorkDetailPolicy
{

    /**
     * Se chequea si los nuevos datos laborales puede ser creado
     * por el usuario actualmente haciendo la peticion.
     * @param \PCI\Models\User $user El usuario haciendo la peticion.
     * @param \PCI\Models\WorkDetail $workDetail datos laborales..
     * @param \PCI\Models\Employee $employee El modelo relacionado con el empleado.
     * @return bool
     */
    public function create(User $user, WorkDetail $workDetail, Employee $employee)
    {
        if (!$workDetail instanceof WorkDetail) {
            throw new \LogicException;
        }

        // el empleado solo puede tener
        // un set de datos laborales.
        if ($employee->workDetails) {
            return false;
        }

        // si no es administrador, solo el usuario puede
        // crear su propia informacion personal.
        return $user->isOwnerOrAdmin($employee->user_id);
    }

    /**
     * Se chequea si los datos laborales pueden ser actualizados
     * por el usuario actualmente haciendo la peticion.
     * @param \PCI\Models\User $user El usuario haciendo la peticion.
     * @param \PCI\Models\WorkDetail $model El empleado a manipular.
     * @return bool
     */
    public function update(User $user, WorkDetail $model)
    {
        return $user->isOwnerOrAdmin($model->employee->user_id);
    }
}
