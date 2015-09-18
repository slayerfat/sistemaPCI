<?php namespace PCI\Repositories;

use Illuminate\Database\Eloquent\Model;

class ViewVariables
{

    /**
     * El Modelo a manipular
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $model;

    /**
     * @var string
     */
    private $destView;

    /**
     * El objetivo del usuario descrito en una
     * frase corta, Ej: Crear Perfil
     * @var string
     */
    private $usersGoal;

    /**
     * @var string
     */
    private $foreignKey;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $parent;

    /**
     * El titulo del padre es la descripcion textual formateada
     * para algun formulario u otro elemento.
     * @var string
     */
    private $parentTitle;

    /**
     * Genera una instancia de ViewVariables, que sirve para generar
     * formularios genericos de entidades secundarias.
     *
     * de ser necesario se puede especificar el padre, la llave foranea
     * y el titulo del padre para generar un formulario con foreign key.
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $usersGoal
     * @param string $destView
     */
    public function __construct(Model $model = null, $usersGoal = '', $destView = '')
    {
        $this->model     = $model;
        $this->usersGoal = $usersGoal;
        $this->destView  = $destView;
    }

    /**
     * Regresa los objetivos del usuario para la vista por defecto.
     * @return string
     */
    public function __toString()
    {
        return $this->getUsersGoal();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
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
     * @return string
     */
    public function getDestView()
    {
        return $this->destView;
    }

    /**
     * @param string $destView
     */
    public function setDestView($destView)
    {
        $this->destView = $destView;
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @param string $foreignKey
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;
    }

    /**
     * @return Model
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $field
     * @param string $id
     * @return array
     */
    public function getParentLists($field = 'desc', $id = 'id')
    {
        $parent = new $this->parent;

        return $parent->lists($field, $id);
    }

    /**
     * @param Model $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Chequea si existe o no algun pariente para
     * el modelo que esta siendo manipulado.
     * @return bool
     */
    public function hasParent()
    {
        return isset($this->parent) && !is_null($this->parent);
    }

    /**
     * @return string
     */
    public function getParentTitle()
    {
        return $this->parentTitle;
    }

    /**
     * @param string $parentTitle
     */
    public function setParentTitle($parentTitle)
    {
        $this->parentTitle = $parentTitle;
    }
}
