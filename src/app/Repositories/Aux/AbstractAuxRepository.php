<?php namespace PCI\Repositories\Aux;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\ViewVariable\ViewCollectionVariable;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class AbstractAuxRepository
 * @package PCI\Repositories\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractAuxRepository extends AbstractRepository
{

    /**
     * Completa la accion generica de instanciar
     * al modelo y persistir los datos.
     * @param array $data La informacion del modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance($data);

        $model->save();

        return $model;
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
        $model = $this->find($id);

        $model->desc = $data['desc'];

        $model->save();

        return $model;
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id El identificador unico.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        return $this->getById($id);
    }

    /**
     * Genera la data necesaria que utilizara el paginator.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return array<string, string> Arreglo asociativo con el slug y desc.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        return [
            'uid'         => $model->slug,
            'Descripción' => $model->desc,
        ];
    }

    /**
     * Genera una instancia de ViewModelVariable
     * dandole una implementacion de AbstractBaseModel.
     * Cambiada la implementacion de ViewModelVariable.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource El identificador o alias.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    protected function generateViewVariable(AbstractBaseModel $model, $resource)
    {
        return new ViewModelVariable($model, $resource);
    }

    /**
     * Genera una instancia de ViewCollectionVariable,
     * con una colecion de modelos.
     * @param \Illuminate\Database\Eloquent\Collection $model
     * @param string $resource El identificador o alias.
     * @return \PCI\Repositories\ViewVariable\ViewCollectionVariable
     */
    protected function generateViewCollectionVariable(Collection $model, $resource)
    {
        return new ViewCollectionVariable($model, $resource);
    }

    /**
     * Genera una instancia de ViewCollectionVariable,
     * con una colecion de modelos.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @param string $resource El identificador o alias.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    protected function generateViewPaginatorVariable(LengthAwarePaginator $paginator, $resource)
    {
        return new ViewPaginatorVariable($paginator, $resource);
    }

    /**
     * Busca todos los modelos y regresa un paginator.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getPaginator()
    {
        $collection = $this->getAll();

        $results = $this->generatePaginator($collection);

        return $results;
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }
}
