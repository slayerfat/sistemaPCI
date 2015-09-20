<?php namespace Tests\PCI\Mamarrachismo\PhoneParser;

use PCI\Mamarrachismo\PhoneParser\PhoneParser;
use Tests\AbstractTestCase;

class PhoneParserTest extends AbstractTestCase
{

    /**
     * @var \PCI\Mamarrachismo\PhoneParser\PhoneParser
     */
    private $parser;

    public function setUp()
    {
        parent::setUp();

        $this->parser = new PhoneParser();
    }

    /**
     * @dataProvider numberDataProvider
     */
    public function testParseNumberShouldReturnValidFormat($value, $expected)
    {
        $this->assertEquals($expected, $this->parser->parseNumber($value));
    }

    /**
     * @dataProvider stringDataProvider
     */
    public function testParseStringShouldReturnValidFormat($value, $expected)
    {
        $this->assertEquals($expected, $this->parser->parseString($value));
    }

    public function numberDataProvider()
    {
        return [
            'valid string'   => ['00001234455', '(000)-123-4455'],
            'valid number'   => [1112221122, '(111)-222-1122'],
            'invalid string' => ['not a valid phone', ''],
            'null input'     => [null, ''],
        ];
    }

    public function stringDataProvider()
    {
        return [
            'valid string'               => ['00001234455', '00001234455'],
            'valid number'               => [1112221122, '1112221122'],
            'invalid string'             => ['not a valid phone', ''],
            'valid string with random'   => ['algo1232224455xzx', '1232224455'],
            'invalid string with random' => ['invalid 111 23 number 123a', ''],
            'null input'                 => [null, ''],
        ];
    }
}
