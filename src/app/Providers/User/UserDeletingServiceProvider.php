<?php namespace PCI\Providers\User;

use LogicException;
use PCI\Models\User;
use Illuminate\Support\ServiceProvider;
use PCI\Providers\Exceptions\AdminCountException;

class UserDeletingServiceProvider extends ServiceProvider
{

    /**
     * Esta es la mejor forma que conozco para registrar este evento.
     * (no se si esto es peor que hacerlo directamente en el modelo)
     * chequea si el usuario que se esta eliminando posee un
     * id relacionado con si mismo o si es admin y ve
     * si existe la logica adecuada para eliminarlo.
     * @return void
     */
    public function boot()
    {
        User::deleting(function ($user) {
            // se chequea si es administrador para que el query no sea nulo.
            if ($user->profile_id == User::ADMIN_ID) {
                $this->checkAdminCount();
            }

            $id = $this->getAdminId();

            // si alguno de estos es verdadero, revienta un
            // Integrity constraint violation
            if ($user->created_by == $user->id || $user->updated_by == $user->id) {
                $user->created_by = $id;
                $user->updated_by = $id;

                $user->save();
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //User::deleting no se registra aqui.
    }

    /**
     * Si por alguna razon no existe administrador, se bota una excepcion.
     * @return int
     * @throws \LogicException
     */
    private function getAdminId()
    {
        $user = User::whereProfileId(User::ADMIN_ID)->first();

        if (!$user) {
            throw new LogicException('El Sistema no tiene Administradores.');
        }

        return $user->id;
    }

    /**
     * Se chequea la cantidad de administradores en el sistema.
     * si es menor o igual a 1 se bota una excepcion.
     * @return void
     * @throws \PCI\Providers\Exceptions\AdminCountException
     */
    private function checkAdminCount()
    {
        $admins = User::whereProfileId(User::ADMIN_ID)->count();

        if ($admins <= 1) {
            throw new AdminCountException('El Sistema debe tener al menos un Administrador.');
        }
    }
}
