<?php namespace PCI\Repositories\Aux;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\ViewVariables;
use Illuminate\Database\Eloquent\Model;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return $this->getById($id);
    }

    /**
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariables
     */
    public function getBySlugOrId($id)
    {
        $cat = parent::getBySlugOrId($id);

        $variable = $this->generateViewVariable($cat, 'cats');
        $variable->getDestView('cats.show');

        return $variable;
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data)
    {
        $cat = $this->model->newInstance($data);

        $cat->save();

        return $cat;
    }

    /**
     * Actualiza algun modelo.
     * @param int   $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\Illuminate\Database\Eloquent\Model|null
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     * @return \PCI\Repositories\ViewVariables
     */
    public function getCreateViewVariables()
    {
        $results = $this->generateViewVariable($this->newInstance(), 'cats');

        $results->setUsersGoal(trans('defaults.cats.create'));
        $results->setDestView('cats.store');

        return $results;
    }

    /**
     * Genera una instancia de ViewVariable
     * dandole una instancia de Category.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource
     * @return \PCI\Repositories\ViewVariables
     */
    private function generateViewVariable(AbstractBaseModel $model, $resource)
    {
        return new ViewVariables($model, $resource);
    }
}
