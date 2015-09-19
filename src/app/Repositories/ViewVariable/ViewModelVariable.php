<?php namespace PCI\Repositories\ViewVariable;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\ViewVariable\Interfaces\GetModelInterface;

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
     * @param string $resource
     */
    public function __construct(AbstractBaseModel $model, $resource)
    {
        $this->setModel($model);
        $this->resource = $resource;

        $this->setViews();
        $this->setRoutes();
        $this->setNames();
    }

    /**
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     * @return void
     */
    public function setModel(AbstractBaseModel $model)
    {
        $this->model = $model;
    }
}
