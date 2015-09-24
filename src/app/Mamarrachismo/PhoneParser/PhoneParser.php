<?php namespace PCI\Mamarrachismo\PhoneParser;

use PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface;

/**
 * Class PhoneParser
 * @package PCI\Mamarrachismo\PhoneParser
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PhoneParser implements PhoneParserInterface
{

    /**
     * Regular Expresion para el numero de telefono con formato Venezolano.
     * 0123456478
     *
     * @var string
     */
    private $completePhoneRegex = '/(?P<cero>[0]?)(?P<code>[0-9]{3})(?P<trio>[\d]{3})(?P<gangbang>[\d]{4})/';

    /**
     * Regular Expresion para el numero de telefono con formato no Venezolano.
     * 01234564789
     *
     * @var string
     */
    private $rawPhoneRegex = '/(?P<cero>0)?(?P<numbers>\d{10})/';

    /**
     * Chequea y devuelve el telefono acomodado.
     * ej: 02123334422 -> (212)-333-4422
     * @param int|string $number el numero, ej: 02123334422
     * @return string regresa en formato (212)-333-4422
     */
    public function parseNumber($number)
    {
        if (is_null($number)) {
            return '';
        }

        $matches = $this->execute($this->completePhoneRegex, $number);

        if (sizeof($matches) > 1) {
            return "({$matches['code']})-{$matches['trio']}-{$matches['gangbang']}";
        }

        return '';
    }

    /**
     * Ejecuta la comprobacion por medio de regex
     * y devuelve lo se pudo capturar.
     * @param string $regex el regex a ejecutar
     * @param string $data el texto al que se hara la comprobacion.
     * @return string[]
     */
    private function execute($regex, $data)
    {
        $matches = [];

        preg_match($regex, (string) $data, $matches);

        return $matches;
    }

    /**
     * Chequea y devuelve el telefono acomodado.
     * ej: algo1232224455xzx -> 1232224455
     * @param string $number el texto con el numero.
     * @return string regresa el numero, ej: 1232224455
     */
    public function parseString($number)
    {
        if (is_null($number)) {
            return '';
        }

        $matches = $this->execute($this->rawPhoneRegex, $number);

        if (sizeof($matches) > 0) {
            return $matches['numbers'];
        }

        return '';
    }
}
