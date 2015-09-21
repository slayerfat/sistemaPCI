<?php namespace PCI\Repositories\Aux;

use PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface;

class MakerRepository extends AbstractAuxRepository implements MakerRepositoryInterface
{

    /**
     * Elimina del sistema un modelo.
     * @param $id
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.maker.singular'));
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $results = $this->getPaginator();

        $variable = $this->generateViewPaginatorVariable($results, 'makers');

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
        $dept = $this->getBySlugOrId($id);

        $variable = $this->generateViewVariable($dept, 'makers');
        $variable->setDestView('makers.show');

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
        $results = $this->generateViewVariable($this->newInstance(), 'makers');

        $results->setUsersGoal(trans('models.makers.create'));
        $results->setDestView('makers.store');

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
        $dept = $this->getBySlugOrId($id);

        return $this->generateViewVariable($dept, 'makers');
    }
}
