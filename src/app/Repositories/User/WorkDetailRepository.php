<?php namespace PCI\Repositories\User;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface;

/**
 * Class WorkDetailRepository
 * @package PCI\Repositories\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class WorkDetailRepository extends AbstractRepository implements WorkDetailRepositoryInterface
{

    /**
     * La implementacion del repositorio de empleado.
     * @var \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface
     */
    private $parentRepo;

    /**
     * Genera una nueva instancia del repositorio.
     * Este depende del repositorio de empleado.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface $empRepo
     */
    public function __construct(AbstractBaseModel $model, EmployeeRepositoryInterface $empRepo)
    {
        parent::__construct($model);

        $this->parentRepo = $empRepo;
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
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        /** @var \PCI\Models\WorkDetail $workDetail */
        $workDetail = $this->newInstance($data);

        /** @var \PCI\Models\Employee $employee */
        $employee = $this->findParent($data['employee_id']);

        $employee->workDetails()->save($workDetail);

        // se regresa al usuario porque se va a mostrar en
        // la vista al usuario relacionado con esta
        // nueva informacion de datos laborales.
        return $employee->user;
    }

    /**
     * Busca al padre relacionado directamente con
     * este modelo, si existen varios padres,
     * entonces se devuelve el mas importante
     * en contexto al repositorio.
     * @param string|int $id El identificador unico (name|slug|int).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function findParent($id)
    {
        return $this->parentRepo->find($id);
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     * @param int $id El identificador unico.
     * @param array $data El arreglo con informacion relacionada al modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        /** @var \PCI\Models\WorkDetail $workDetail */
        $workDetail = $this->find($id);
        $workDetail->fill($data);

        $workDetail->save();

        $workDetail->load('employee.user', 'employee');

        return $workDetail->employee->user;
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        return $this->getById($id);
    }

    /**
     * Elimina del sistema un modelo.
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.workDetails.singular'));
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        // TODO: Implement makePaginatorData() method.
    }
}
