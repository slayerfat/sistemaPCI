<?php namespace PCI\Repositories\ViewVariable;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\ViewVariable\Interfaces\GetModelInterface;

/**
 * Class ViewModelVariable
 * @package PCI\Repositories\ViewVariable
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ViewModelVariable extends AbstractViewVariable implements GetModelInterface
{

    /**
     * El Modelo a manipular
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $model;

    /**
     * Genera una instancia de ViewModelVariable, que sirve para generar
     * formularios genericos de entidades secundarias.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource El identificador o alias.
     */
    public function __construct(AbstractBaseModel $model, $resource)
    {
        $this->setModel($model);
        $this->resource = $resource;

        $this->setViews();
        $this->setRoutes();
        $this->setTrans();
    }

    /**
     * Regresa al modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Guarda algun modelo.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return void
     */
    public function setModel(AbstractBaseModel $model)
    {
        $this->model = $model;
    }
}
