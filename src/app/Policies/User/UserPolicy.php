<?php namespace PCI\Policies\User;

use PCI\Models\User;

/**
 * Class UserPolicy
 * @package PCI\Policies\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * Debido a que Laravel ayuda con el registro de usuario no es
 * necesario declarar una poliza para crear usuario, debido
 * a que el registro es validado en el cotrolador de
 * autenticacion y  solamente un administrador
 * puede crear nuevos usuarios.
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UserPolicy
{

    /**
     * Chequea que el usuario que prepende actualizar
     * otro sea administrador o el mismo usuario.
     * @param \PCI\Models\User $user El usuario en el sistema.
     * @param \PCI\Models\User $model El modelo que se pretende actualizar.
     * @return bool
     */
    public function update(User $user, User $model)
    {
        return $user->isOwnerOrAdmin($model->id);
    }

    /**
     * Chequea que el usuario que quiere eliminar sea administrador.
     * @param \PCI\Models\User $user
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->isAdmin();
    }
}
