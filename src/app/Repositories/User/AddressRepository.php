<?php namespace PCI\Repositories\User;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;

class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{

    /**
     * @var \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface
     */
    private $empRepo;

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     * @param \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface $empRepo
     */
    public function __construct(
        AbstractBaseModel $model,
        EmployeeRepositoryInterface $empRepo
    ) {
        parent::__construct($model);

        $this->empRepo = $empRepo;
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return \PCI\Models\User
     */
    public function create(array $data)
    {
        // buscamos al empleado primero para saber que existe
        /** @var \PCI\Models\Employee $employee */
        $employee = $this->findParent($data['employee_id']);

        /** @var \PCI\Models\Address $address */
        $address = $this->newInstance($data);
        $address->save();

        $employee->address_id = $address->id;
        $employee->save();

        // devolvemos al usuario porque el controlador
        // redirecciona a la vista de usuarios.
        return $employee->user;
    }

    /**
     * @param string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function findParent($id)
    {
        return $this->empRepo->find($id);
    }

    /**
     * Actualiza algun modelo.
     * @param int $id
     * @param array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        $address = $this->find($id);
        $address->load('employee.user');

        // por alguna razon, save no estaba funcionado
        // por eso se invoca fill antes del save.
        $address->fill($data)->save();

        return $address->employee->user;
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        return $this->getById($id);
    }

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Dirección');
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
