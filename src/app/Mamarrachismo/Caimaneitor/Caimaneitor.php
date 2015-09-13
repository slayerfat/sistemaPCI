<?php namespace PCI\Mamarrachismo\Caimaneitor;

use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Caimaneitor\Interfaces\CaimanizerInterface;

class Caimaneitor implements CaimanizerInterface
{

    /**
     * Inspired by Illuminate\Foundation\Inspiring
     * A very Inspiring class.
     *
     * Alejandro Granadillo made this commit from Caracas. (45° Celcius)
     *
     * @return Collection
     */
    public static function caimanais()
    {
        return Collection::make([

            'Puro cara e\' papeo. - Bryan Torres',
            'Tranquilo que en vacaciones me pongo pa\' eso. - Andres Leotur',
            'Si, si... eso lo hago yo. - Erick Zerpa',
            '¿Que tipo de relacion es una relacion de tipo muchos a muchos? - Anonimo',
            '¿Cuanto es uno por menos uno? - Anonimo',

        ])->random();
    }
}
