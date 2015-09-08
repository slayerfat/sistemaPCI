<?php namespace Tests;

use Mockery;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

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
