<?php namespace Tests\PCI\Repositories\Aux;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Category;
use PCI\Models\Department;
use PCI\Models\Gender;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Models\MovementType;
use PCI\Models\Nationality;
use PCI\Models\NoteType;
use PCI\Models\PetitionType;
use PCI\Models\Profile;
use PCI\Models\SubCategory;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Aux\DepartmentRepository;
use PCI\Repositories\Aux\GenderRepository;
use PCI\Repositories\Aux\ItemTypesRepository;
use PCI\Repositories\Aux\MakerRepository;
use PCI\Repositories\Aux\MovementTypeRepository;
use PCI\Repositories\Aux\NationalityRepository;
use PCI\Repositories\Aux\NoteTypeRepository;
use PCI\Repositories\Aux\PetitionTypeRepository;
use PCI\Repositories\Aux\ProfileRepository;
use PCI\Repositories\Aux\SubCategoryRepository;
use Tests\AbstractTestCase;

/** @SuppressWarnings(PHPMD.CouplingBetweenObjects) */
class ViewableInterfaceRepositoryTest extends AbstractTestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    public function dataProvider()
    {
        return [
            'category'      => [CategoryRepository::class, Category::class],
            'department'    => [DepartmentRepository::class, Department::class],
            'gender'        => [GenderRepository::class, Gender::class],
            'itemTypes'     => [ItemTypesRepository::class, ItemType::class],
            'maker'         => [MakerRepository::class, Maker::class],
            'movementTypes' => [
                MovementTypeRepository::class,
                MovementType::class
            ],
            'nationality'   => [
                NationalityRepository::class,
                Nationality::class
            ],
            'noteTypes'     => [NoteTypeRepository::class, NoteType::class],
            'petitionType'  => [
                PetitionTypeRepository::class,
                PetitionType::class
            ],
            'profile'       => [ProfileRepository::class, Profile::class],
            'subCat'        => [
                SubCategoryRepository::class,
                SubCategory::class
            ],
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
    }

    /**
     * @dataProvider dataProvider
     * @param $repository
     * @param $model
     */
    public function testDelete($repository, $model)
    {
        $repo = new $repository(new $model);

        $model = factory($model)->create();

        $this->assertTrue($repo->delete($model->id));
    }

    /**
     * @dataProvider dataProvider
     * @param $repository
     * @param $model
     */
    public function testGetIndexViewVariablesShouldNotBeNull($repository, $model)
    {
        /** @var \PCI\Repositories\Interfaces\Viewable\ViewableInterface $repo */
        $repo = new $repository(new $model);

        factory($model)->create();

        $variable = $repo->getIndexViewVariables();

        $this->assertNotEmpty($variable);
        $this->assertInstanceOf(\PCI\Repositories\ViewVariable\ViewPaginatorVariable::class, $variable);
    }

    /**
     * @dataProvider dataProvider
     * @param $repository
     * @param $model
     */
    public function testGetShowViewVariablesShouldNotBeNull($repository, $model)
    {
        $data = [];

        /** @var \PCI\Repositories\Interfaces\Viewable\ViewableInterface $repo */
        $repo = new $repository(new $model);

        factory($model)->create();

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
