<?php namespace Tests\PCI\Repositories\Item;

use PCI\Models\Depot;
use PCI\Models\User;
use PCI\Repositories\Item\DepotRepository;
use PCI\Repositories\User\UserRepository;
use Tests\PCI\Repositories\AbstractRepositoryTestCase;

/**
 * Class DepotRepositoryTest
 * @package Tests\PCI\Repositories\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotRepositoryTest extends AbstractRepositoryTestCase
{

    /**
     * La instancia del repositorio usuado por la prueba.
     * @var \PCI\Repositories\Item\DepotRepository
     */
    protected $repo;

    /**
     * La instancia del modelo relacionado con la prueba.
     * @var \PCI\Models\Depot
     */
    protected $model;

    public function testFindShouldntBeEmpty()
    {
        $this->assertNotEmpty($this->repo->find($this->model->id));
    }

    public function testCreateShouldReturnDepot()
    {
        $data = [
            'user_id' => 1,
            'number'  => 1,
            'rack'    => 1,
            'shelf'   => 1
        ];

        $results = $this->repo->create($data);

        $this->assertInstanceOf(Depot::class, $results);
    }

    public function testUpdateShouldReturnDepot()
    {
        $data = [
            'user_id' => 1,
            'number'  => 2,
            'rack'    => 4,
            'shelf'   => 3
        ];

        $depot = factory(Depot::class)->create();

        $results = $this->repo->update($depot->id, $data);

        $this->assertInstanceOf(Depot::class, $results);
    }

    public function testUpdateShouldReturnTrueWhenDeleteIsSuccessful()
    {
        $depot = factory(Depot::class)->create();

        $results = $this->repo->delete($depot->id);

        $this->assertTrue($results);
    }

    public function testGetAllShouldntBeEmpty()
    {
        $this->assertNotEmpty($this->repo->getAll());
    }

    public function testGetgetIndexViewVariablesShouldntBeEmpty()
    {
        $this->assertInstanceOf(
            \PCI\Repositories\ViewVariable\ViewPaginatorVariable::class,
            $this->repo->getIndexViewVariables()
        );
    }

    public function testGetTablePaginatorShouldntBeEmpty()
    {
        $this->assertInstanceOf(
            \Illuminate\Pagination\LengthAwarePaginator::class,
            $this->repo->getTablePaginator()
        );
    }

    /**
     * Crea el repositorio necesario para esta prueba.
     * @return \PCI\Repositories\AbstractRepository
     */
    protected function makeRepo()
    {
        return new DepotRepository(
            new Depot,
            new UserRepository(new User())
        );
    }

    /**
     * Crea el modelo necesario para esta prueba.
     * @return \PCI\Models\AbstractBaseModel
     */
    protected function makeModel()
    {
        return factory(Depot::class)->create();
    }
}
