<?php namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;
use PCI\Http\ViewComposers\NavbarViewComposer;
use PCI\Http\ViewComposers\UserShowViewComposer;

/**
 * Class ViewComposerServiceProvider
 * @package PCI\Providers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ViewComposerServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // aqui es donde se genera las variables relacionadas
        // con el navbar, incluyendo aquellas relacionadas
        // con el perfil del usuario activo en sistema
        view()->composer(
            'partials.navbar',
            NavbarViewComposer::class
        );

        // este composer se encarga de instanciar un
        // PhoneParser y otras posibles variables
        // para ser utilizadas por la vista.
        view()->composer(
            'users.show',
            UserShowViewComposer::class
        );
    }
}
