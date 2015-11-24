<?php namespace PCI\Repositories\Aux;

use PCI\Models\AbstractBaseModel;
use PCI\Models\MovementType;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use PCI\Repositories\ViewVariable\NoteTypeViewModelVariable;

/**
 * Class NoteTypeRepository
 *
 * @package PCI\Repositories\Aux
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteTypeRepository extends AbstractAuxRepository implements NoteTypeRepositoryInterface
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
        $model                   = $this->model->newInstance($data);
        $model->movement_type_id = $data['movement_type_id'];
        $model->save();

        return $model;
    }

    /**
     * Elimina a este modelo del sistema.
     *
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.noteTypes.singular'));
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

        $variable = $this->generateViewPaginatorVariable($results, 'noteTypes');

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
        $dept = $this->getBySlugOrId($id);

        $variable = $this->generateViewVariable($dept, 'noteTypes');
        $variable->setDestView('noteTypes.show');

        return $variable;
    }

    /**
     * Genera una instancia de ViewModelVariable
     * dandole una implementacion de AbstractBaseModel.
     * Cambiada la implementacion de ViewModelVariable.
     *
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string                        $resource El identificador o alias.
     * @return \PCI\Repositories\ViewVariable\SubCategoryViewModelVariable
     */
    protected function generateViewVariable(
        AbstractBaseModel $model,
        $resource = 'subCats'
    ) {
        return new NoteTypeViewModelVariable($model, $resource);
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
        $results = $this->generateViewVariable($this->newInstance(), 'noteTypes');

        $results->setUsersGoal(trans('models.noteTypes.create'));
        $results->setDestView('noteTypes.store');

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

        return $this->generateViewVariable($dept, 'noteTypes');
    }

    /**
     * Genera una collection de tipos segun el perfil del usuario.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists()
    {
        if ($this->getCurrentUser()->isAdmin()) {
            return $this->model->orderBy('id', 'asc')->lists('desc', 'id');
        }

        $id = MovementType::out()->first()->id;

        return $this->model->where('movement_type_id', $id)->lists('desc', 'id');
    }
}
