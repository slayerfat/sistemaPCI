<?php namespace Tests\Integration\Misc;

use Tests\BaseTestCase;

class StatusIntegrationTest extends BaseTestCase
{

    public function testStatusIsOk()
    {
        $this->visit('/status')
            ->see(trans('defaults.appName'));
    }
}
