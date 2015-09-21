<?php namespace Tests\Integration\Misc;

use Tests\AbstractTestCase;

class StatusIntegrationTest extends AbstractTestCase
{

    public function testStatusIsOk()
    {
        $this->visit('/status')
            ->see(trans('defaults.appName'));
    }
}
