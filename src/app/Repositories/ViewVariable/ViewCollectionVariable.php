<?php namespace PCI\Repositories\ViewVariable;

use Illuminate\Database\Eloquent\Collection;
use PCI\Repositories\ViewVariable\Interfaces\GetModelCollectionInterface;

/**
 * Class ViewCollectionVariable
 * @package PCI\Repositories\ViewVariable
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
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
     * @param string $resource el modelo a manipular
     */
    public function __construct(Collection $model, $resource)
    {
        $this->setModel($model);

        $this->resource = $resource;

        $this->setViews();
        $this->setRoutes();
        $this->setTrans();
    }

    /**
     * Regresa al modelo.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Guarda alguna Coleccion.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     * @param \Illuminate\Database\Eloquent\Collection|null $collection
     */
    public function setModel(Collection $collection)
    {
        $this->model = $collection;
    }
}
