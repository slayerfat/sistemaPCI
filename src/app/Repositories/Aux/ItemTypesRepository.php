<?php namespace PCI\Repositories\Aux;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\Interfaces\Aux\ItemTypesRepositoryInterface;
use PCI\Repositories\ViewVariable\ItemTypeViewModelVariable;

/**
 * Class ItemTypesRepository
 *
 * @package PCI\Repositories\Aux
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemTypesRepository extends AbstractAuxRepository implements ItemTypesRepositoryInterface
{

    /**
     * Persiste informacion referente a una entidad.
     * Se sobrescribe del padre porque es
     * necesaria logica adicional.
     *
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\Petition
     */
    public function create(array $data)
    {
        $model             = $this->model->newInstance($data);
        $model->perishable = $data['perishable'];
        $model->save();

        return $model;
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     *
     * @param int   $id   El identificador unico.
     * @param array $data El arreglo con informacion relacionada al modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        $model             = $this->find($id);
        $model->desc       = $data['desc'];
        $model->perishable = $data['perishable'];
        $model->save();

        return $model;
    }

    /**
     * Elimina a este modelo del sistema.
     *
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
     *
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
     *
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getShowViewVariables($id)
    {
        $item = $this->getBySlugOrId($id);

        $variable = $this->generateViewVariable($item, 'itemTypes');
        $variable->setDestView('itemTypes.show');

        return $variable;
    }

    /**
     * Genera una instancia de ViewModelVariable
     * dandole una implementacion de AbstractBaseModel.
     * Cambiada la implementacion de ViewModelVariable.
     *
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string                        $resource El identificador o alias.
     * @return \PCI\Repositories\ViewVariable\ItemTypeViewModelVariable
     */
    protected function generateViewVariable(
        AbstractBaseModel $model,
        $resource = 'itemTypes'
    ) {
        return new ItemTypeViewModelVariable($model, $resource);
    }

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     *
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
     *
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getEditViewVariables($id)
    {
        $dept = $this->getBySlugOrId($id);

        return $this->generateViewVariable($dept, 'itemTypes');
    }
}
