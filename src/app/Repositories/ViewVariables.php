<?php namespace PCI\Repositories;

use Illuminate\Database\Eloquent\Model;

class ViewVariables
{

    /**
     * @var Model
     */
    private $model;

    /**
     * @var string
     */
    private $viewName;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $viewName
     */
    public function __construct(Model $model = null, $viewName = null)
    {
        $this->model = $model;
        $this->viewName = $viewName;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * @param string $viewName
     */
    public function setViewName($viewName)
    {
        $this->viewName = $viewName;
    }
}
