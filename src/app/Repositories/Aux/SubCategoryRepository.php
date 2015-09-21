<?php namespace PCI\Repositories\Aux;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\Interfaces\Aux\SubCategoryRepositoryInterface;
use PCI\Repositories\ViewVariable\SubCategoryViewModelVariable;

class SubCategoryRepository extends AbstractAuxRepository implements SubCategoryRepositoryInterface
{

    public function create(array $data)
    {
        $model = $this->model->newInstance($data);
        $model->category_id = $data['category_id'];
        $model->save();

        return $model;
    }

    /**
     * Elimina del sistema un modelo.
     * @param $id
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
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la vista.
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getShowViewVariables($id)
    {
        $cat = $this->getBySlugOrId($id);

        return $this->generateViewVariable($cat);
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
     * Regresa variable con un modelo y datos
     * adicionales necesarios para generar la
     * vista con el proposito de Model Binding.
     * @param string|int $id
     * @return \PCI\Repositories\ViewVariable\ViewModelVariable
     */
    public function getEditViewVariables($id)
    {
        $cat = $this->getBySlugOrId($id);

        return $this->generateViewVariable($cat);
    }

    /**
     * Genera una instancia de ViewModelVariable
     * dandole una implementacion de AbstractBaseModel.
     * Cambiada la implementacion de ViewModelVariable.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource
     * @return \PCI\Repositories\ViewVariable\SubCategoryViewModelVariable
     */
    protected function generateViewVariable(AbstractBaseModel $model, $resource = 'subCats')
    {
        return new SubCategoryViewModelVariable($model, $resource);
    }
}
