<?php namespace PCI\Repositories\Aux;

use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use PCI\Repositories\ViewVariable\ViewModelVariable;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;
use PCI\Repositories\ViewVariable\ViewCollectionVariable;

abstract class AbstractAuxRepository extends AbstractRepository
{

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
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance($data);

        $model->save();

        return $model;
    }

    /**
     * Actualiza algun modelo.
     * @param int   $id
     * @param array $data
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
     * genera la data necesaria que utilizara el paginator.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return array
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
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    protected function generateViewVariable(AbstractBaseModel $model, $resource)
    {
        return new ViewModelVariable($model, $resource);
    }

    /**
     * Genera una instancia de ViewCollectionVariable
     * con una colecion de modelos.
     * @param \Illuminate\Database\Eloquent\Collection $model
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\ViewCollectionVariable
     */
    protected function generateViewCollectionVariable(Collection $model, $resource)
    {
        return new ViewCollectionVariable($model, $resource);
    }

    /**
     * Genera una instancia de ViewCollectionVariable
     * con una colecion de modelos.
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    protected function generateViewPaginatorVariable(LengthAwarePaginator $paginator, $resource)
    {
        return new ViewPaginatorVariable($paginator, $resource);
    }
}
