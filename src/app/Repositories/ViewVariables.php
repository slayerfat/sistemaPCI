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
     * @var string
     */
    private $usersGoal;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $viewName
     * @param string $usersGoal
     */
    public function __construct(Model $model = null, $viewName = '', $usersGoal = '')
    {
        $this->model = $model;
        $this->viewName = $viewName;
        $this->usersGoal = $usersGoal;
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
     * @return string
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

    /**
     * @return string
     */
    public function getUsersGoal()
    {
        return $this->usersGoal;
    }

    /**
     * @param string $usersGoal
     */
    public function setUsersGoal($usersGoal)
    {
        $this->usersGoal = $usersGoal;
    }

    /**
     * Regresa los objetivos del usuario para la vista por defecto.
     * @return string
     */
    public function __toString()
    {
        return $this->getUsersGoal();
    }
}
