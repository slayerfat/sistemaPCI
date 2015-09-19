<?php namespace Tests\PCI\Repositories\ViewVariable;

use PCI\Models\User;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;
use Tests\BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Repositories\ViewVariable\ViewCollectionVariable;

class GetXInterfaceTest extends BaseTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var \PCI\Repositories\ViewVariable\AbstractViewVariable[]
     */
    private $variables;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->variables = [
            new ViewCollectionVariable(User::all(), 'tests'),
            new ViewModelVariable(User::first(), 'tests'),
            new ViewPaginatorVariable(User::paginate(), 'tests'),
        ];
    }

    public function testGetModel()
    {
        foreach ($this->variables as $obj) {
            $this->assertNotEmpty($obj->getModel());
        }
    }

    public function testTostring()
    {
        foreach ($this->variables as $obj) {
            $this->assertNotEmpty($obj->__toString());
        }
    }
}
