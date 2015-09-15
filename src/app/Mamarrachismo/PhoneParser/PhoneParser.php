<?php namespace PCI\Mamarrachismo\PhoneParser;

use PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface;

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
     * @param int $number
     * @return string
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
     * Chequea y devuelve el telefono acomodado.
     * ej: algo1232224455xzx -> 1232224455
     * @param int $number
     * @return int
     */
    public function parseString($number)
    {
        if (is_null($number)) {
            return 0;
        }

        $matches = $this->execute($this->rawPhoneRegex, $number);

        if (sizeof($matches) > 0) {
            return $matches['numbers'];
        }

        return 0;
    }

    /**
     * @param $regex
     * @param $number
     * @return array
     */
    private function execute($regex, $number)
    {
        $matches = [];

        preg_match($regex, $number, $matches);

        return $matches;
    }
}
