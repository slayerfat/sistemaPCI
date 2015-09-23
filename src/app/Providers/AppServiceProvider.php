<?php namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // Por alguna razon (en gran parte por mi ignorancia y falta de tiempo)
        // autoload.php no quiere incluir este archivo cuando se ejecutan las
        // pruebas, pero si lo incluye cuando se ejecuta la aplicacion de forma
        // normal, hace falta hacer pruebas al respecto, pero por ahora este
        // asunto funciona mamarrachamente.
        include __DIR__.'/../../../public/laravel_pls.php';

        // Cambia la direccion del directorio en $app
        // publico del standard a lo que sea, en este caso se cambio de
        // ~/sistemaPCI/src/public
        // a
        // ~/sistemaPCI/public
        $this->app->bind('path.public', function () {
            return laravel_pls();
        });
    }
}
