<?php namespace Tests\PCI\Repositories\ViewVariable;

use stdClass;
use Mockery;
use PCI\Models\User;
use Tests\AbstractTestCase;
use PCI\Models\Employee;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AbstractViewVariableTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @var \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    private $var;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->var = new ViewModelVariable(new Employee, 'tests');
    }

    public function testUsersGoal()
    {
        $this->var->setUsersGoal('test');

        $this->assertEquals('test', $this->var->getUsersGoal());
    }

    public function testDestView()
    {
        $this->var->setDestView('test');

        $this->assertEquals('test', $this->var->getDestView());
    }

    public function testInitialView()
    {
        $this->var->setInitialView('test');

        $this->assertEquals('test', $this->var->getInitialView());
    }

    public function testForeignKey()
    {
        $this->var->setForeignKey('test');

        $this->assertEquals('test', $this->var->getForeignKey());
    }

    public function testParent()
    {
        $this->var->setParent(Employee::class);

        $this->assertTrue($this->var->hasParent());
        $this->assertTrue(is_a($this->var->getParent(), Employee::class));
    }

    public function testParentLists()
    {
        $this->var->setParent(User::class);

        $this->assertNotEmpty($this->var->getParentLists('name'));
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->var->getParentLists('name'));
    }

    public function testHasParent()
    {
        $this->assertFalse($this->var->hasParent());
    }

    public function testParentTitle()
    {
        $this->var->setParentTitle('test');

        $this->assertEquals('test', $this->var->getParentTitle());
    }

    public function testResource()
    {
        $this->var->setResource('test');

        $this->assertEquals('test', $this->var->getResource());
    }

    /**
     * @return \StdClass
     */
    public function testRoutes()
    {
        $this->assertInstanceOf('StdClass', $this->var->getRoutes());
    }

    /**
     * @return \StdClass
     */
    public function testNames()
    {
        $this->assertInstanceOf('StdClass', $this->var->getRoutes());
    }
}
