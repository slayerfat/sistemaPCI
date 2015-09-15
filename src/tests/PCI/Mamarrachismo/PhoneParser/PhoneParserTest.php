<?php namespace Tests\PCI\Mamarrachismo\PhoneParser;

use PCI\Mamarrachismo\PhoneParser\PhoneParser;
use Tests\BaseTestCase;

class PhoneParserTest extends BaseTestCase
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

    public function testParseNumberShouldReturnValidFormat()
    {
        $number = '00001234455';

        $this->assertEquals('(000)-123-4455', $this->parser->parseNumber($number));

        $number = 1112221122;

        $this->assertEquals('(111)-222-1122', $this->parser->parseNumber($number));

        $number = 'not a valid phone';

        $this->assertEquals('', $this->parser->parseNumber($number));
    }

    public function testParseStringShouldReturnValidFormat()
    {
        $number = '00001234455';

        $this->assertEquals('00001234455', $this->parser->parseString($number));

        $number = 1112221122;

        $this->assertEquals('1112221122', $this->parser->parseString($number));

        $number = 'algo1232224455xzx';

        $this->assertEquals('1232224455', $this->parser->parseString($number));


        $number = 'invalid 111 23 number 123a';

        $this->assertEquals('', $this->parser->parseString($number));
    }
}
