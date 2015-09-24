<?php namespace PCI\Repositories\Aux;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface;
use PCI\Repositories\ViewVariable\SubCategoryViewModelVariable;

/**
 * Class SubCategoryRepository
 * @package PCI\Repositories\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class SubCategoryRepository extends AbstractAuxRepository implements SubCategoryRepositoryInterface
{

    /**
     * Persiste informacion referente a una entidad.
     * Se sobrescribe del padre porque es
     * necesaria logica adicional.
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\SubCategory
     */
    public function create(array $data)
    {
        $model = $this->model->newInstance($data);
        $model->category_id = $data['category_id'];
        $model->save();

        return $model;
    }

    /**
     * Elimina a este modelo del sistema.
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.subCats.singular'));
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $results = $this->getPaginator();

        $variable = $this->generateViewPaginatorVariable($results, 'subCats');

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
        $variable = $this->generateViewVariable($this->newInstance());

        $variable->setUsersGoal(trans('models.subCats.create'));
        $variable->setDestView('subCats.store');

        return $variable;
    }

    /**
     * Genera una instancia de ViewModelVariable
     * dandole una implementacion de AbstractBaseModel.
     * Cambiada la implementacion de ViewModelVariable.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource El identificador o alias.
     * @return \PCI\Repositories\ViewVariable\SubCategoryViewModelVariable
     */
    protected function generateViewVariable(AbstractBaseModel $model, $resource = 'subCats')
    {
        return new SubCategoryViewModelVariable($model, $resource);
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
        return $this->getShowViewVariables($id);
    }

    /**
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la vista.
     * @param string|int $id El identificador unico, slug o id.
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getShowViewVariables($id)
    {
        $cat = $this->getBySlugOrId($id);

        return $this->generateViewVariable($cat);
    }
}
