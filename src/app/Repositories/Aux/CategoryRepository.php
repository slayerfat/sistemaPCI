<?php namespace PCI\Repositories\Aux;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends AbstractAuxRepository implements CategoryRepositoryInterface
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
        $cat = $this->model->newInstance($data);

        $cat->save();

        return $cat;
    }

    /**
     * Actualiza algun modelo.
     * @param int   $id
     * @param array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        /** @var \PCI\Models\Category $cat */
        $cat = $this->find($id);

        $cat->desc = $data['desc'];

        $cat->save();

        return $cat;
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
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $collection = $this->getAll();

        $results = $this->generatePaginator($collection);

        $variable = $this->generateViewPaginatorVariable($results, 'cats');

        return $variable;
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la vista.
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getShowViewVariables($id)
    {
        $cat = $this->getBySlugOrId($id);

        $variable = $this->generateViewVariable($cat, 'cats');
        $variable->setDestView('cats.show');

        return $variable;
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getCreateViewVariables()
    {
        $results = $this->generateViewVariable($this->newInstance(), 'cats');

        $results->setUsersGoal(trans('defaults.cats.create'));
        $results->setDestView('cats.store');

        return $results;
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la
     * vista con el proposito de Model Binding.
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getEditViewVariables($id)
    {
        $cat = $this->getBySlugOrId($id);

        return $this->generateViewVariable($cat, 'cats');
    }

    /**
     * genera la data necesaria que utilizara el paginator.
     *
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Category $cat
     * @return array
     */
    protected function makePaginatorData(AbstractBaseModel $cat)
    {
        return [
            'uid'         => $cat->desc,
            'Descripción' => $cat->desc,
        ];
    }
}
