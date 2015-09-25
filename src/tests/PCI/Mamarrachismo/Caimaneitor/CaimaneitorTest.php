<?php namespace Tests\PCI\Mamarrachismo\Caimaneitor;

use Caimaneitor;
use Tests\AbstractTestCase;

class CaimaneitorTest extends AbstractTestCase
{

    public function testCaimaneitorShouldCaimanais()
    {
        $this->assertNotEmpty(Caimaneitor::caimanais());
    }

    public function testCaimaneitorShouldGiveLocaishon()
    {
        $this->assertNotEmpty(Caimaneitor::locaishon());
    }

    public function testCaimaneitorNeedsToImplementMagicToString()
    {
        $caimanity = new \PCI\Mamarrachismo\Caimaneitor\Caimaneitor();
        $this->assertInternalType('string', (string) $caimanity);
    }
}
