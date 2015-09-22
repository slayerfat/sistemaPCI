<?php namespace PCI\Repositories\User;

use Gate;
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
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param array $data
     * @return \PCI\Models\User
     */
    public function create(array $data)
    {
        /** @var \PCI\Models\Employee $employee */
        $employee = $this->newInstance($data);

        $user = $this->findUser($data['user_id']);

        $employee->user_id = $user->id;

        $user->employee()->save($employee);

        return $user;
    }

    /**
     * @param string|int $id
     * @return \PCI\Models\User
     */
    public function findUser($id)
    {
        return $this->userRepo->find($id);
    }

    /**
     * Actualiza algun modelo.
     * @param int $id
     * @param array $data
     * @return \PCI\Models\User
     */
    public function update($id, array $data)
    {
        /** @var \PCI\Models\Employee $employee */
        $employee = $this->find($id);
        $employee->fill($data);

        $employee->save();

        $employee->load('user');

        return $employee->user;
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        $employee = $this->getById($id);

        return $employee;
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
     * @param string $policyName el nombre de la poliza a ejecutar
     * @param string|int $id el identificador del modelo a ser manipulado.
     * @return bool verdadero si puede manipular.
     */
    public function canUser($policyName, $id)
    {
        return Gate::allows($policyName, $this->model->findOrNew($id));
    }

    /**
     * @param string $policyName el nombre de la poliza a ejecutar
     * @param  string|int $id el identificador del modelo a ser manipulado.
     * @return bool verdadero si NO puede manipular.
     */
    public function cantUser($policyName, $id)
    {
        return Gate::denies($policyName, $this->find($id));
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
