<?php

namespace PCI\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * Class EncryptCookies
 * @package PCI\Http\Middleware
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EncryptCookies extends BaseEncrypter
{
    /**
     * The trans of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
