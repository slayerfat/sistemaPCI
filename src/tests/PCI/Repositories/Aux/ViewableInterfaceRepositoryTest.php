<?php namespace Tests\PCI\Repositories\Aux;

use PCI\Models\Department;
use PCI\Models\Gender;
use PCI\Repositories\Aux\DepartmentRepository;
use PCI\Repositories\Aux\GenderRepository;
use Tests\AbstractTestCase;
use PCI\Models\Category;
use PCI\Repositories\Aux\CategoryRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewableInterfaceRepositoryTest extends AbstractTestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @var \PCI\Repositories\Aux\AbstractAuxRepository[]
     */
    private $repos = [];

    /**
     * @var \PCI\Models\AbstractBaseModel[]
     */
    private $model = [];

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $array = [
            [CategoryRepository::class, Category::class],
            [DepartmentRepository::class, Department::class],
            [GenderRepository::class, Gender::class],
        ];

        foreach ($array as $data) {
            $this->repos[] = new $data[0](new $data[1]());

            $this->model[] = factory($data[1])->create();
        }
    }

    public function testDelete()
    {
        /** @var \PCI\Repositories\Interfaces\ModelRepositoryInterface $repo */
        foreach ($this->repos as $key => $repo) {
            $this->assertTrue($repo->delete($this->model[$key]->id));
        }
    }

    public function testGetIndexViewVariablesShouldNotBeNull()
    {
        /** @var \PCI\Repositories\Interfaces\Viewable\ViewableInterface $repo */
        foreach ($this->repos as $repo) {
            $variable = $repo->getIndexViewVariables();

            $this->assertNotEmpty($variable);
            $this->assertInstanceOf(\PCI\Repositories\ViewVariable\ViewPaginatorVariable::class, $variable);
        }
    }

    public function testGetShowViewVariablesShouldNotBeNull()
    {
        $data = [];

        /** @var \PCI\Repositories\Interfaces\Viewable\ViewableInterface $repo */
        foreach ($this->repos as $repo) {
            $data[] = $repo->getShowViewVariables(1);
            $data[] = $repo->getCreateViewVariables();
            $data[] = $repo->getEditViewVariables(1);

            foreach ($data as $variable) {
                $this->assertNotEmpty($variable);
                $this->assertInstanceOf(
                    \PCI\Repositories\ViewVariable\ViewModelVariable::class,
                    $variable
                );
            }
        }
    }
}
