<?php namespace PCI\Mamarrachismo\Caimaneitor;

use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Caimaneitor\Interfaces\CaimanizerInterface;

class Caimaneitor implements CaimanizerInterface
{

    public static $caimaneishons = [
        'Puro cara e\' papeo. - Bryan Torres',
        'Tranquilo que en vacaciones me pongo pa\' eso. - Andres Leotur',
        'Si, si... eso lo hago yo. - Erick Zerpa',
        '¿Que tipo de relacion es una relacion de tipo muchos a muchos? - Anonimo',
        '¿Cuanto es uno por menos uno? - Anonimo',
        'Tuve que darle la vuelta al mundo
        para darme cuenta que la solucion estaba detras de mi. - Alejandro Granadillo',
    ];

    public static $locaishons = [

        'Con cinco tragos de mas en la taguara La Barcaza Azul.',
        'Tomando Roncito en Los Caracas.',
        'Durante la prueba de calculo.',
        'En el anden del Metro de Caracas.',
        'Durante la Pre-defensa de Proyecto.',
        'Via Skype.',
        'Via Gmail.',

    ];

    /**
     * Inspired by Illuminate\Foundation\Inspiring
     * A very Inspiring class.
     *
     * Alejandro Granadillo made this commit from Caracas. (45° Celcius)
     *
     * @return string
     */
    public static function caimanais()
    {
        return Collection::make(self::$caimaneishons)->random();
    }

    /**
     * Inspired by PCI\Mamarrachismo\Caimaneitor\Caimaneitor
     * A very Inspiring class.
     *
     * Alejandro Granadillo made this commit from Caracas, Again.
     *
     * @return string
     */
    public static function locaishon()
    {
        return Collection::make(self::$locaishons)->random();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return self::caimanais();
    }
}
