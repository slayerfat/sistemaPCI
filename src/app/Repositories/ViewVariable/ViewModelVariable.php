<?php namespace PCI\Repositories\ViewVariable;

use Illuminate\Support\Collection;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\ViewVariable\Interfaces\FormFieldsInterface;
use PCI\Repositories\ViewVariable\Interfaces\GetModelInterface;

/**
 * Class ViewModelVariable
 *
 * @package PCI\Repositories\ViewVariable
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ViewModelVariable extends AbstractViewVariable implements GetModelInterface, FormFieldsInterface
{

    /**
     * El Modelo a manipular
     *
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $model;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $fields;

    /**
     * Genera una instancia de ViewModelVariable, que sirve para generar
     * formularios genericos de entidades secundarias.
     *
     * @param AbstractBaseModel $model
     * @param string            $resource El identificador o alias.
     */
    public function __construct(AbstractBaseModel $model, $resource)
    {
        $this->setModel($model);
        $this->resource = $resource;
        $this->fields = Collection::make();

        $this->setViews();
        $this->setRoutes();
        $this->setTrans();
    }

    /**
     * Regresa al modelo.
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Guarda algun modelo.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     *
     * @param \PCI\Models\AbstractBaseModel $model
     * @return void
     */
    public function setModel(AbstractBaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * Determina si existen campos adicionales.
     *
     * @return bool
     */
    public function hasFields()
    {
        return !$this->fields->isEmpty();
    }

    /**
     * Determina si no existen campos adicionales.
     *
     * @return bool
     */
    public function areFieldsEmpty()
    {
        return $this->fields->isEmpty();
    }

    /**
     * Regresa una coleccion de campos relacionados con el formulario.
     *
     * @return Collection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Añade un nuevo campo de formulario a la coleccion existente.
     *
     * @param $fields
     */
    public function setFields($fields)
    {
        $this->fields->push($fields);
    }
}
