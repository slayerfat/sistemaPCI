<?php namespace PCI\Repositories\ViewVariable;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\ViewVariable\Interfaces\ViewVariableInterface;
use StdClass;

/**
 * Class AbstractViewVariable
 * @package PCI\Repositories\ViewVariable
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link http://i.imgur.com/xVyoSl.jpg
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractViewVariable implements ViewVariableInterface
{

    /**
     * El Modelo a manipular
     */
    protected $model;

    /**
     * La vista destino que la activdad
     * esta por logica destinada a ir,
     * util para el controlador y vistas.
     * @var string
     */
    protected $destView;

    /**
     * La vista inicial, util para el controlador y vistas.
     * @var string
     */
    protected $initialView;

    /**
     * El objetivo del usuario descrito en una
     * frase corta, Ej: Crear Perfil
     * @var string
     */
    protected $usersGoal;

    /**
     * El nombre de la llave foranea del modelo.
     * @var string
     */
    protected $foreignKey;

    /**
     * El modelo padre relacionado.
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $parent;

    /**
     * El titulo del padre es la descripcion textual formateada
     * para algun formulario u otro elemento.
     * @var string
     */
    protected $parentTitle;

    /**
     * El identificador users, notes, etc
     * para generar las vistas y enlaces
     * user.show, users.index, etc.
     * @var string
     */
    protected $resource;

    /**
     * Contiene las rutas, routes->show, routes->index
     * @var \StdClass
     */
    protected $routes;

    /**
     * Contiene los nombres formales en sigular y plural
     * @var \StdClass
     */
    protected $trans;

    /**
     * Los objetivos del usuario en texto legible.
     * @return string
     */
    public function getUsersGoal()
    {
        return $this->usersGoal;
    }

    /**
     * Genera o cambia los objetivos
     * del usuario en la actividad.
     * @param string $usersGoal
     */
    public function setUsersGoal($usersGoal)
    {
        $this->usersGoal = $usersGoal;
    }

    /**
     * La vista destino que la actividad
     * esta por logica destinada a ir.
     * @return string
     */
    public function getDestView()
    {
        return $this->destView;
    }

    /**
     * Cambia o guarda la vista destino.
     * @param string $destView
     */
    public function setDestView($destView)
    {
        $this->destView = $destView;
    }

    /**
     * La vista inicial en 'vista.tal' para
     * ser utilizada por View.
     * @return string
     */
    public function getInitialView()
    {
        return $this->initialView;
    }

    /**
     * Guarda la vista inicial.
     * La vista inicial en 'vista.tal' para
     * ser utilizada por View.
     * @param string $initialView
     */
    public function setInitialView($initialView)
    {
        $this->initialView = $initialView;
    }

    /**
     * Llave foranea segun la estructura de datos.
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * Cambia la llave foranea segun la estructura de datos
     * @param string $foreignKey
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;
    }

    /**
     * Regresa el modelo Eloquent del padre
     * relacionado al modelo principal.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getParent()
    {
        return new $this->parent;
    }

    /**
     * el string de forma ::class del padre relacionado.
     * @param \PCI\Models\AbstractBaseModel $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Ejecuta un query y genera un array asociativo
     * segun los parametros datos en este metodo.
     * @param string $field el campo en la base de datos
     * @param string $id el identificador principal
     * @return array<string, string>
     */
    public function getParentLists($field = 'desc', $id = 'id')
    {
        /** @var AbstractBaseModel $parent */
        $parent = new $this->parent;

        return $parent->lists($field, $id);
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
     * El nombre formal del padre en formato legible.
     * @return string
     */
    public function getParentTitle()
    {
        return $this->parentTitle;
    }

    /**
     * Cambia el nombre formal del modelo padre.
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
     * Cambia el nombre identificador del modelo principal.
     * Este identificador es el nombre corto
     * y en plural del modelo, {users},
     * {notes}, {addresses}, etc...
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Rutas necesarias para manipular al
     * modelo en las vistas y controladores
     * @return \StdClass
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Genera las rutas necesarias para manipular al
     * modelo en las vistas y controladores
     * @return void
     */
    protected function setRoutes()
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
     * Regresa un objeto generico con todas las
     * variables relacionadas con el modelo.
     * estas variables son las que se encuentran en
     * resource/lang/es/models.php
     * @return \StdClass
     */
    public function getTrans()
    {
        return $this->trans;
    }

    /**
     * Genera los nombres formales.
     * Estos nombres estan en un objeto que
     * contiene todos los elementos principales
     * descritos en resource/lang/es/models.php
     * @return void
     */
    protected function setTrans()
    {
        $this->trans = new StdClass;

        // se genera segun el recurso todos las variables
        // el recurso es el alinas corto del modelo o ruta.
        $types       = [
            'singular' => trans("models.{$this->resource}.singular"),
            'plural'   => trans("models.{$this->resource}.plural"),
            'index'    => trans("models.{$this->resource}.index"),
            'show'     => trans("models.{$this->resource}.show"),
            'create'   => trans("models.{$this->resource}.create"),
            'edit'     => trans("models.{$this->resource}.edit"),
            'update'   => trans("models.{$this->resource}.update"),
            'fa-icon'  => trans("models.{$this->resource}.fa-icon"),
        ];

        // por cada key del array se genera
        // un atributo del objeto generico.
        foreach ($types as $type => $def) {
            $this->trans->$type = $def;
        }
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
     * El modelo principal.
     * @return mixed
     */
    abstract public function getModel();

    /**
     * Ejecuta los metodos minimos necesarios para
     * que la instancia de esta clase tenga lo
     * necesario que necesitan las vistas.
     * @param $resource
     * @return void
     */
    protected function setDefaults($resource)
    {
        $this->resource = $resource;

        $this->setViews();
        $this->setRoutes();
        $this->setTrans();
    }

    /**
     * genera la vista inicial (a donde se va inicialmente) y la
     * vista de destino (a donde se pretende ir, si aplica)
     * @return void
     */
    protected function setViews()
    {
        $this->initialView = "{$this->resource}.index";
        $this->destView    = "{$this->resource}.show";
    }
}
