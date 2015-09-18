<?php namespace PCI\Repositories\ViewVariable;

use Illuminate\Database\Eloquent\Collection;
use PCI\Repositories\ViewVariable\Interfaces\GetModelCollectionInterface;

class ViewCollectionVariable extends AbstractViewVariable implements GetModelCollectionInterface
{

    /**
     * El Modelo a manipular
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $model;

    /**
     * Genera una instancia de ViewModelVariable, que sirve para generar
     * formularios genericos de entidades secundarias.
     * @param \Illuminate\Database\Eloquent\Collection $model
     * @param string $resource
     */
    public function __construct(Collection $model, $resource)
    {
        $this->setModel($model);

        $this->resource = $resource;

        $this->setViews();
        $this->setRoutes();
        $this->setNames();
    }

    /**
     * Regresa el modelo en json.
     * @return string
     */
    public function __toString()
    {
        return $this->getModel()->toJson();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|null $model
     */
    public function setModel(Collection $model)
    {
        $this->model = $model;
    }
}
