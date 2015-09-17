<?php namespace PCI\Providers\User;

use PCI\Models\User;
use Illuminate\Support\ServiceProvider;

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
                $admins = User::whereProfileId(User::ADMIN_ID)->count();

                // como este el usuario es el unico administrador en el sistema
                // se regresa para que reviente por el Repositorio.
                if ($admins <= 1) {
                    return;
                }
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
     * @return int
     * @throws \Exception
     */
    private function getAdminId()
    {
        $user = User::whereProfileId(User::ADMIN_ID)->first();

        if (!$user) {
            throw new \Exception('El Sistema no tiene Administradores.');
        }

        return $user->id;
    }
}
