<?php namespace Tests\PCI\Repositories\ViewVariable;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\User;
use PCI\Repositories\ViewVariable\ViewCollectionVariable;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;
use Tests\AbstractTestCase;

class GetXInterfaceTest extends AbstractTestCase
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
            new ViewCollectionVariable(User::all(), 'users'),
            new ViewModelVariable(User::first(), 'users'),
            new ViewPaginatorVariable(User::paginate(), 'users'),
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
