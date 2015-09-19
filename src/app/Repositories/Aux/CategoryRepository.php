<?php namespace PCI\Repositories\Aux;

use PCI\Repositories\Interfaces\Aux\CategoryRepositoryInterface;

class CategoryRepository extends AbstractAuxRepository implements CategoryRepositoryInterface
{

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, 'Categoria');
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
}
