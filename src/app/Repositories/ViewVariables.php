<?php namespace PCI\Repositories;

use StdClass;
use PCI\Models\AbstractBaseModel;
use Illuminate\Database\Eloquent\Model;

class ViewVariables
{

    /**
     * El Modelo a manipular
     * @var \PCI\Models\AbstractBaseModel
     */
    private $model;

    /**
     * @var string
     */
    private $destView;

    /**
     * @var string
     */
    private $initialView;

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
     * @var \PCI\Models\AbstractBaseModel
     */
    private $parent;

    /**
     * El titulo del padre es la descripcion textual formateada
     * para algun formulario u otro elemento.
     * @var string
     */
    private $parentTitle;

    /**
     * El identificador users, notes, etc
     * para generar las vistas y enlaces
     * user.show, users.index, etc.
     * @var string
     */
    private $resource;

    /**
     * Contiene las rutas, routes->show, routes->index
     * @var \StdClass
     */
    private $routes;

    /**
     * Contiene los nombres formales en sigular y plural
     * @var \StdClass
     */
    private $names;

    /**
     * Genera una instancia de ViewVariables, que sirve para generar
     * formularios genericos de entidades secundarias.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource
     */
    public function __construct(AbstractBaseModel $model, $resource)
    {
        $this->model    = $model;
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
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     */
    public function setModel(AbstractBaseModel $model)
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
    public function getInitialView()
    {
        return $this->initialView;
    }

    /**
     * @param string $initialView
     */
    public function setInitialView($initialView)
    {
        $this->initialView = $initialView;
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
        /** @var AbstractBaseModel $parent */
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

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Genera las rutas necesarias para manipular al
     * modelo en las vistas y controladores
     */
    private function setRoutes()
    {
        $this->routes = new StdClass;
        $routes       = [
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ];

        foreach ($routes as $route) {
            $this->routes->$route = "{$this->resource}.$route";
        }
    }

    /**
     * @return StdClass
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return \StdClass
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Genera los nombres formales.
     */
    private function setNames()
    {
        $this->names = new StdClass;
        $types       = [
            'singular' => trans("defaults.{$this->resource}.singular"),
            'plural'   => trans("defaults.{$this->resource}.plural"),
        ];

        foreach ($types as $type => $def) {
            $this->names->$type = $def;
        }
    }

    /**
     * genera la vista inicial (a donde se va inicialmente) y la
     * vista de destino (a donde se pretende ir, si aplica)
     */
    private function setViews()
    {
        $this->initialView = "{$this->resource}.index";
        $this->destView    = "{$this->resource}.show";
    }
}
