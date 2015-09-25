<?php namespace Tests\PCI\Repositories\Aux;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Category;
use PCI\Repositories\Aux\CategoryRepository;
use Tests\AbstractTestCase;

class AbstractAuxRepositoryTest extends AbstractTestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * @var \PCI\Repositories\Aux\CategoryRepository
     */
    private $repo;

    /**
     * @var \PCI\Models\Category
     */
    private $model;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->repo = new CategoryRepository(new Category());

        $this->model = factory(Category::class)->create();
    }

    public function createUpdatedataProvider()
    {
        return [
            ['ayy', ]
        ];
    }

    public function testFind()
    {
        $model = $this->repo->find(1);

        $this->assertNotEmpty($model);
        $this->assertInstanceOf(Category::class, $model);
    }

    public function testGetAll()
    {
        $model = $this->repo->getAll();

        $this->assertNotEmpty($model);
    }

    /**
     * @dataProvider createUpdatedataProvider
     * @param string $value
     */
    public function testCreate($value)
    {
        $model = $this->repo->create(['desc' => $value]);

        $this->assertNotEmpty($model);
        $this->assertInstanceOf(Category::class, $model);
    }

    /**
     * @dataProvider createUpdatedataProvider
     * @param string $value
     */
    public function testUpdate($value)
    {
        $model = $this->repo->update(1, ['desc' => $value]);

        $this->assertNotEmpty($model);
        $this->assertInstanceOf(Category::class, $model);
    }
}
