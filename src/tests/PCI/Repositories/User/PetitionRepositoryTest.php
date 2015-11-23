<?php namespace Tests\PCI\Repositories\User;

use PCI\Mamarrachismo\Collection\ItemCollection;
use PCI\Mamarrachismo\Converter\StockTypeConverter;
use PCI\Models\Category;
use PCI\Models\Item;
use PCI\Models\MovementType;
use PCI\Models\Petition;
use PCI\Models\StockType;
use PCI\Models\User;
use PCI\Repositories\Aux\CategoryRepository;
use PCI\Repositories\Item\ItemRepository;
use PCI\Repositories\User\PetitionRepository;
use Tests\PCI\Repositories\AbstractRepositoryTestCase;

/**
 * Class PetitionRepositoryTest
 *
 * @package Tests\PCI\Repositories\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRepositoryTest extends AbstractRepositoryTestCase
{

    /**
     * @var \PCI\Repositories\User\PetitionRepository
     */
    protected $repo;

    /**
     * @var \PCI\Models\User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
    }

    public function testGetAllShouldNotBeEmpty()
    {
        $admin = factory(User::class)->create(['profile_id' => User::ADMIN_ID]);

        $nonAdmin = factory(User::class)->create(['profile_id' => User::USER_ID]);

        $this->actingAs($admin)
            ->assertNotEmpty($this->repo->getAll());

        $this->actingAs($this->user)
            ->assertNotEmpty($this->repo->getAll());

        $this->actingAs($nonAdmin)
            ->assertTrue($this->repo->getAll()->isEmpty());
    }

    public function testFindShouldReturnModel()
    {
        $this->assertNotEmpty($this->repo->find(1));
        $this->assertInstanceOf(Petition::class, $this->repo->find(1));
    }

    /**
     * @dataProvider createDataProvider
     * @param array $data
     */
    public function testCreateShouldReturnItem($data)
    {
        $this->actingAs($this->user)->assertInstanceOf(
            Petition::class,
            $petition = $this->repo->create($data)
        );

        $this->seeInDatabase('petitions', ['created_at' => $petition->created_at]);
    }

    public function createDataProvider()
    {
        $collection = new ItemCollection;
        $collection->setRequiredFields('itemId', 'amount', 'stockTypeId')
            ->setAmount(1)
            ->setStockTypeId(1)
            ->setItemId(1)
            ->make()
            ->setItemId(2)
            ->make();

        $another = new ItemCollection;
        $another->setRequiredFields('itemId', 'amount', 'stockTypeId')
            ->setAmount(1)
            ->setStockTypeId(1)
            ->setItemId(1)
            ->make()
            ->setStockTypeId(2)
            ->make();

        return [
            [
                'sameType'      => [
                    'comments'         => 'testing comment',
                    'petition_type_id' => 1,
                    'itemCollection'   => $collection,
                ],
                'differentType' => [
                    'comments'         => 'testing comment',
                    'petition_type_id' => 1,
                    'itemCollection'   => $another,
                ],
            ],
        ];
    }

    public function testDeleteShouldReturnBoolean()
    {
        $petition = factory(Petition::class)->create(['status' => null]);
        $this->assertTrue(is_bool($this->repo->delete($petition->id)));
    }

    /**
     * @dataProvider changeStatusProvider
     * @param bool $param
     * @param bool $expected
     */
    public function testChangeStatusShouldReturnBoolean($param, $expected)
    {
        $this->assertEquals($expected, $this->repo->changeStatus(1, $param));
    }

    public function changeStatusProvider()
    {
        return [
            'true'          => [true, true],
            'stringTrue'    => ['true', true],
            'false'         => [false, true],
            'stringFalse'   => ['false', true],
            'null'          => [null, true],
            'stringNull'    => ['null', true],
            'invalidInput1' => ['a', false],
            'invalidInput2' => ['1', false],
        ];
    }

    /**
     * Crea el repositorio necesario para esta prueba.
     *
     * @return \PCI\Repositories\AbstractRepository
     */
    protected function makeRepo()
    {
        $itemRepo = new ItemRepository(
            new Item(),
            new CategoryRepository(new Category())
        );

        return new PetitionRepository(
            new Petition,
            $itemRepo,
            new StockTypeConverter
        );
    }

    /**
     * Crea el modelo necesario para esta prueba.
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    protected function makeModel()
    {
        $this->user = factory(User::class)->create();

        // necesitamos tipo de movimiento para verificar pedido
        factory(MovementType::class)->create(['desc' => 'Entrada']);
        factory(MovementType::class)->create(['desc' => 'Salida']);

        // lastimosamente el pedido necesita muchos modelos.
        factory(Petition::class)->create(['user_id' => $this->user->id]);
        factory(Petition::class, 5)->create();
        factory(StockType::class, 5)->create();
        factory(Item::class)->create(['stock_type_id' => 1]);
        factory(Item::class)->create(['stock_type_id' => 2]);
    }
}
