<?php namespace Tests;

use Mockery;
use PHPUnit_Framework_TestCase;

abstract class AbstractPhpUnitTestCase extends PHPUnit_Framework_TestCase
{

    /**
     * Genera un mock y comprueba el return value de este.
     * @param string $mockedClass
     * @param string $method
     * @param string $shouldRecieve
     * @param string $withVariable
     */
    protected function mockBasicModelRelation($mockedClass, $method, $shouldRecieve, $withVariable)
    {
        $model = Mockery::mock($mockedClass)->makePartial();

        $model->shouldReceive($shouldRecieve)
            ->once()
            ->with($withVariable)
            ->andReturn('mocked');

        $this->assertEquals('mocked', $model->$method());
    }
}
