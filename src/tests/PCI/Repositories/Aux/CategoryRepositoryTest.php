<?php namespace Tests\PCI\Repositories\Aux;

use Tests\AbstractTestCase;
use PCI\Models\Category;
use PCI\Repositories\Aux\CategoryRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryRepositoryTest extends AbstractTestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @var \PCI\Repositories\Aux\CategoryRepository
     */
    private $catRepo;

    /**
     * @var \PCI\Models\Category
     */
    private $cat;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->catRepo = new CategoryRepository(new Category());

        $this->cat = factory(Category::class)->create();
    }

    public function testDelete()
    {
        $this->assertTrue($this->catRepo->delete(1));
    }

    public function testGetIndexViewVariablesShouldNotBeNull()
    {
        $variable = $this->catRepo->getIndexViewVariables();

        $this->assertNotEmpty($variable);
        $this->assertInstanceOf(\PCI\Repositories\ViewVariable\ViewPaginatorVariable::class, $variable);
    }

    public function testGetShowViewVariablesShouldNotBeNull()
    {
        $data = [];
        $data[] = $this->catRepo->getShowViewVariables(1);
        $data[] = $this->catRepo->getCreateViewVariables();
        $data[] = $this->catRepo->getEditViewVariables(1);

        foreach ($data as $var) {
            $this->assertNotEmpty($var);
            $this->assertInstanceOf(\PCI\Repositories\ViewVariable\ViewModelVariable::class, $var);
        }
    }
}
