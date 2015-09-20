<?php

namespace PCI\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

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
