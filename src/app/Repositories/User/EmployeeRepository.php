<?php namespace PCI\Repositories\User;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;

class EmployeeRepository extends AbstractRepository implements EmployeeRepositoryInterface
{

    /**
     * @var \PCI\Repositories\Interfaces\User\UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface $userRepo
     */
    public function __construct(AbstractBaseModel $model, UserRepositoryInterface $userRepo)
    {
        parent::__construct($model);

        $this->userRepo = $userRepo;
    }

    /**
     * @param string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function findUser($id)
    {
        return $this->userRepo->find($id);
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        $employee = $this->getByNameOrId($id);

        return $employee;
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * Actualiza algun modelo.
     * @param int $id
     * @param array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        // TODO: Implement makePaginatorData() method.
    }
}
