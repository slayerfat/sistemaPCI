<?php namespace PCI\Mamarrachismo\PhoneParser\Interfaces;

interface PhoneParserInterface
{

    /**
     * Chequea y devuelve el telefono acomodado.
     * ej: 02123334422 -> (212)-333-4422
     * @param int|string $number el numero, ej: 02123334422
     * @return string regresa en formato (212)-333-4422
     */
    public function parseNumber($number);

    /**
     * Chequea y devuelve el telefono acomodado.
     * ej: algo1232224455xzx -> 1232224455
     * @param string $number el texto con el numero.
     * @return string regresa el numero, ej: 1232224455
     */
    public function parseString($number);
}
