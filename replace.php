<?php

/**
 * Esta mamarrachada puede ser mejorada.
 *
 * Este script es utilizado para cambiar una linea en especifico
 * en una clase dentro de las librerias relacionadas con laravel.
 *
 * este cambio se debe a que en la linea original ($this->laravel->publicPath)
 * tiene por defecto la estructura original del directorio (.../app/public/)
 * este fue cambiado a la composicion actual (.../public/)
 *
 * este hack funciona para que php artisan serve funcione en ambiente local.
 *
 * NO ESTA PROBADO para produccion.
 */

// el archivo a manipular
$file = __DIR__.'/src/vendor/laravel/framework/src/Illuminate/Foundation/Console/ServeCommand.php';

// la linea infractora
$original = 'chdir($this->laravel->publicPath());';

// detallese que se cambia a ('/')
$replace  = 'chdir(\'/\');';

// los contenidos del archivo
$str = file_get_contents($file);

// se remplaza mamarrachamente
$str = str_replace($original, $replace, $str);

// se guardan los cambios y se cierra el archivo.
$fp = fopen($file, 'w');
fwrite($fp, $str);
fclose($fp);
