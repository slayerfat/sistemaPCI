<?php namespace PCI\Repositories\User;

use Gate;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;

/**
 * Class EmployeeRepository
 * @package PCI\Repositories\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class EmployeeRepository extends AbstractRepository implements EmployeeRepositoryInterface
{

    /**
     * El repositorio del que depende este.
     * @var \PCI\Repositories\Interfaces\User\UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Genera una instancia del repositorio.
     * Este depende del modelo Usuario y el repositorio de Usuario.
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
        return $this->model->all();
    }

    /**
     * Persiste informacion referente a una entidad.
     * Se sobrescribe del padre porque es
     * necesaria logica adicional.
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\User Regresa al usuario, no al empleado.
     */
    public function create(array $data)
    {
        /** @var \PCI\Models\Employee $employee */
        $employee = $this->newInstance($data);

        /** @var \PCI\Models\User $user */
        $user = $this->findParent($data['user_id']);

        $employee->user_id = $user->id;

        $user->employee()->save($employee);

        // se regresa al usuario porque se va a mostrar
        // en la vista al usuario relacionado con
        // esta nueva informacion de empleado.
        return $user;
    }

    /**
     * Busca al padre relacionado directamente con
     * este modelo, si existen varios padres,
     * entonces se devuelve el mas importante
     * en contexto al repositorio.
     * @param string|int $id El identificador unico (name|slug|int).
     * @return \PCI\Models\Employee
     */
    public function findParent($id)
    {
        return $this->userRepo->find($id);
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     * @param int $id El identificador unico.
     * @param array $data El arreglo con informacion relacioada al modelo.
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
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        $employee = $this->getById($id);

        return $employee;
    }

    /**
     * Elimina del sistema un modelo.
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Información Personal');
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
