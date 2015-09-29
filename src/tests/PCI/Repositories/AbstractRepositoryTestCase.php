<?php namespace Tests\PCI\Repositories;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AbstractTestCase;

/**
 * Class AbstractRepositoryTestCase
 * @package Tests\PCI\Repositories
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractRepositoryTestCase extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    /**
     * La instancia del repositorio usuado por la prueba.
     * @var \PCI\Repositories\AbstractRepository
     */
    protected $repo;

    /**
     * La instancia del modelo relacionado con la prueba.
     * Este modelo NO es el usuario, sino el modelo
     * relacionado con el repositorio (si aplica).
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $this->repo  = $this->makeRepo();
        $this->model = $this->makeModel();
    }

    /**
     * Crea el repositorio necesario para esta prueba.
     * @return \PCI\Repositories\AbstractRepository
     */
    abstract protected function makeRepo();

    /**
     * Crea el modelo necesario para esta prueba.
     * @return \PCI\Models\AbstractBaseModel
     */
    abstract protected function makeModel();
}
