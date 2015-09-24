<?php namespace PCI\Repositories\Aux;

use PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface;

/**
 * Class ItemTypesRepository
 * @package PCI\Repositories\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemTypesRepository extends AbstractAuxRepository implements ItemTypesRepositoryInterface
{

    /**
     * Elimina a este modelo del sistema.
     * @param int $id El identificador unico, solo id.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.itemType.singular'));
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $results = $this->getPaginator();

        $variable = $this->generateViewPaginatorVariable($results, 'itemTypes');

        return $variable;
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la vista.
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getShowViewVariables($id)
    {
        $dept = $this->getBySlugOrId($id);

        $variable = $this->generateViewVariable($dept, 'itemTypes');
        $variable->setDestView('itemTypes.show');

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
        $results = $this->generateViewVariable($this->newInstance(), 'itemTypes');

        $results->setUsersGoal(trans('models.itemTypes.create'));
        $results->setDestView('itemTypes.store');

        return $results;
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la
     * vista con el proposito de Model Binding.
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getEditViewVariables($id)
    {
        $dept = $this->getBySlugOrId($id);

        return $this->generateViewVariable($dept, 'itemTypes');
    }
}
