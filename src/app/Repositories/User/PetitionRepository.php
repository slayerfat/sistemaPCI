<?php namespace PCI\Repositories\User;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class PetitionRepository
 * @package PCI\Repositories\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRepository extends AbstractRepository implements PetitionRepositoryInterface
{

    /**
     * @var \PCI\Models\Petition
     */
    protected $model;

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        return new ViewPaginatorVariable($this->getTablePaginator(), 'items');
    }

    /**
     * Genera un objeto LengthAwarePaginator con todos los
     * modelos en el sistema y con eager loading (si aplica).
     * @param int $quantity la cantidad a mostrar por pagina.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTablePaginator($quantity = 25)
    {
        return $this->generatePaginator($this->getAll(), $quantity);
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll()
    {
        // debemos saber si el usuario actual en el sistema es
        // administador o no, para saber si debemos
        // devolver todas las peticiones o no.
        $user = $this->getCurrentUser();

        if ($user->isAdmin()) {
            return $this->model->all();
        }

        return $this->model->whereUserId($user->id)->get();
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * Persiste informacion referente a una entidad.
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
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
        // TODO: Implement update() method.
    }

    /**
     * Elimina del sistema un modelo.
     * @param int $id El identificador unico.
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
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Petition $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        // por ahora no necesitamos datos de forma condicional.
        return [
            'uid'                => $model->id,
            'Numero'             => $model->id,
            'Usuario'            => $model->user->name . ' ' . $model->user->email,
            'Tipo'               => $model->type->desc,
            'Fecha de solicitud' => $model->request_date->diffForHumans(),
            'Status'             => $model->status ? 'Aprobado' : 'No Aprobado',
        ];
    }
}
