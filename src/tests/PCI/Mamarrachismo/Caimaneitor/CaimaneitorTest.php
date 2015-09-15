<?php namespace Tests\PCI\Mamarrachismo\Caimaneitor;

use Caimaneitor;
use Tests\BaseTestCase;

class CaimaneitorTest extends BaseTestCase
{

    public function testCaimaneitorShouldCaimanais()
    {
        $this->assertNotEmpty(Caimaneitor::caimanais());
    }

    public function testCaimaneitorShouldGiveLocaishon()
    {
        $this->assertNotEmpty(Caimaneitor::locaishon());
    }
}
