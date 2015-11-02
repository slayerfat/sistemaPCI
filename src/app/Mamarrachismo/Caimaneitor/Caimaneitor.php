<?php

/**
 *  ……………………▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄
 * ……………▄▄█▓▓▓▒▒▒▒▒▒▒▒▒▒▓▓▓▓█▄▄
 * …………▄▀▀▓▒░░░░░░░░░░░░░░░░▒▓▓▀▄
 * ………▄▀▓▒▒░░░░░░░░░░░░░░░░░░░▒▒▓▀▄
 * …..█▓█▒░░░░░░░░░░░░░░░░░░░░░▒▓▒▓█
 * ..▌▓▀▒░░░░░░░░░░░░░░░░░░░░░░░░▒▀▓█
 * ..█▌▓▒▒░░░░░░░░░░░░░░░░░░░░░░░░░▒▓█
 * ▐█▓▒░░░░░░░░░░░░░░░░░░░░░░░░░░░▒▓█▌
 * █▓▒▒░░░░░░░░░░░░░░░░░░░░░░░░░░░░▒▓█
 * █▐▒▒░░░░░░░░░░░░░░░░░░░░░░░░░░░▒▒█▓
 * █▓█▒░░░░░░░░░░░░░░░░░░░░░░░░░░░▒█▌▓█
 * █▓▓█▒░░░░░░░░░░░░░░░░░░░░░░░░░░▒█▓▓█
 * █▓█▒░▒▒▒▒░░▀▀█▄▄░░░░░▄▄█▀▀░░▒▒▒▒░▒█▓█
 * █▓▌▒▒▓▓▓▓▄▄▄▒▒▒▀█░░░░█▀▒▒▒▄▄▄▓▓▓▓▒▒▐▓█
 * ██▌▒▓███▓█████▓▒▐▌░░▐▌▒▓████▓████▓▒▐██
 * .██▒▒▓███ayy████▓▄░░░▄▓████lmao███▓▒▒██
 * .█▓▒▒▓██████████▓▒░░░▒▓██████████▓▒▒▓█
 * ..█▓▒░▒▓███████▓▓▄▀░░▀▄▓▓███████▓▒▒▓█
 * ...█▓▒░▒▒▓▓▓▓▄▄▄▀▒░░░░░▒▀▄▄▄▓▓▓▓▒▒░▓█
 * ....█▓▒░▒▒▒▒░░░░░▒▒▒▒▒▒░░░░░▒▒▒▒░▒▓█
 * .....█▓▓▒▒▒░░░░░░░▒▒▒▒░░░░░▒▒▒▓▓█
 * ......▀██▓▓▓▒░░▄▄▄▄▄▄▄▄▄▄░░▒▓█▀
 * .......▀█▓▒▒░░░░░░▀▀▀▀▒░░▒▒▓█▀
 * ..........██▓▓▒░░▒▒▒░▒▒▒░▒▓██
 * ............█▓▒▒▒░░░░░▒▒▒▓█
 * ..............▀▀█▓▓▓▓▓▓█▀
 */

namespace PCI\Mamarrachismo\Caimaneitor;

use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Caimaneitor\Interfaces\CaimanizerInterface;

/**
 * Class Caimaneitor
 * @package PCI\Mamarrachismo\Caimaneitor
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://uahtechcomm.files.wordpress.com/2014/10/funny-picture-every-group-project.jpg
 * @link http://i3.kym-cdn.com/photos/images/newsfeed/000/215/821/1323635452001.png
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class Caimaneitor implements CaimanizerInterface
{

    /**
     * They see me rollin'...
     * @var string[]
     */
    public static $caimaneishons = [
        'Puro cara e\' papeo. - Bryan Torres',
        '¿Que cara e\' papeo es este? - Bryan Torres',
        'Pero confía en mi. - Bryan Torres',
        'Tu tranquilo que yo nervioso. - Bryan Torres',
        'Tranquilo que en vacaciones me pongo pa\' eso. - Andres Leotur',
        'Tranquilo que en esta semana me pongo pa\' eso. - Andres Leotur',
        'Tranquilo que hoy me pongo pa\' eso. - Andres Leotur',
        'Tranquilo que de aquí al lunes me pongo pa\' eso. - Andres Leotur',
        'Tranquilo que solo hay vender el sistema. - Andres Leotur',
        'Tranquilo que el tiempo de dios es perfecto. - Andres Leotur',
        'Tranquilo que uno se las ingenia. - Andres Leotur',
        'No tengo la culpa de que el sistema no corra. - Andres Leotur',
        'Si, si... eso lo hago yo. - Erick Zerpa',
        '¿Que tipo de relación es una relación de tipo muchos a muchos? - Anónimo',
        '¿Cuanto es uno por menos uno? - Anónimo',
        'No meno\'l... no puedo, tengo culebra en el hueco. - Anónimo',
        'Pero si yo no me acuerdo de ti. - Anónimo',
        'Ya va... que, me esta subiendo la tension. - Alejandro Granadillo',
        'Pero si ese es mi futuro, vale!!! - Alejandro Granadillo',
        'Ayy chamo. - Alejandro Granadillo',
        'Ahh! ya se que es eso. - Alejandro Granadillo',
        'Solo hay que verificar las pruebas de integración con el servidor. - Alejandro Granadillo',
        'Solo hay que verificar las pruebas de aceptación. - Alejandro Granadillo',
        'Solo hay que verificar las pruebas funcionales. - Alejandro Granadillo',
        'Solo hay que verificar las pruebas unitarias. - Alejandro Granadillo',
        'El sistema esta casi listo. - Alejandro Granadillo',
        'El sistema esta en concordancia con lo estipulado en los requerimientos. - Alejandro Granadillo',
        'Tuve que darle la vuelta al mundo
        para darme cuenta que la solución estaba detrás de mi. - Alejandro Granadillo',
    ];

    /**
     * ...they hatin'
     * @var string[]
     */
    public static $locaishons = [
        'Con cinco tragos de mas en la taguara La Barcaza Azul.',
        'En la taguara La pasarela, frente al Metro de Caracas.',
        'Durante el acto de graduación.',
        'Cerca del barrio el \'El Hueco\', La vega.',
        'En las afueras del barrio \'El Hueco\', La vega.',
        'En las cercanías del barrio \'El Hueco\', La vega.',
        'Camino al barrio \'El Hueco\', La vega.',
        'Tomando Roncito en Los Caracas.',
        'Durante la prueba de calculo.',
        'En el anden del Metro de Caracas.',
        'Durante la pre-defensa de Proyecto.',
        'Durante la exposición de Proyecto.',
        'Durante la pre-defensa del Sistema.',
        'Durante la exposición del Sistema.',
        'Via Skype.',
        'Via WhatsApp.',
        'Via Gmail.',
    ];

    /**
     * Inspired by PCI\Mamarrachismo\Caimaneitor\Caimaneitor
     * A very Inspiring class.
     * Alejandro Granadillo made this commit from Caracas, Again.
     * @return string
     */
    public static function locaishon()
    {
        return Collection::make(self::$locaishons)->random();
    }

    /**
     * Regresa un mensaje inspirado.
     * @return string
     */
    public function __toString()
    {
        return self::caimanais();
    }

    /**
     * Inspired by Illuminate\Foundation\Inspiring
     * A very Inspiring class.
     * Alejandro Granadillo made this commit from Caracas. (45° Celcius)
     * @return string
     */
    public static function caimanais()
    {
        return Collection::make(self::$caimaneishons)->random();
    }
}
