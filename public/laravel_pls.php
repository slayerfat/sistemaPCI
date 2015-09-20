<?php

if (! function_exists('laravel_pls')) {
    /**
     * Regresa el path del directorio publico
     * @param string $path
     * @return string
     */
    function laravel_pls($path = '')
    {
        return realpath(__DIR__).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
