<?php namespace PCI\Repositories\ViewVariable\Interfaces;

interface ViewVariableInterface
{

    /**
     * Regresa el modelo en json.
     * @return string
     */
    public function __toString();

    /**
     * Los objetivos del usuario en texto legible.
     * @return string
     */
    public function getUsersGoal();

    /**
     * La vista destino que la actividad
     * esta por logica destinada a ir.
     * @return string
     */
    public function getDestView();

    /**
     * La vista inicial en 'vista.tal' para
     * ser utilizada por View.
     * @return string
     */
    public function getInitialView();

    /**
     * Llave foranea segun la estructura de datos.
     * @return string
     */
    public function getForeignKey();

    /**
     * Regresa el modelo Eloquent del padre
     * relacionado al modelo principal.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getParent();

    /**
     * Ejecuta un query y genera un array asociativo
     * segun los parametros datos en este metodo.
     * @param string $field
     * @param string $id
     * @return array
     */
    public function getParentLists($field = 'desc', $id = 'id');

    /**
     * Chequea si existe o no algun pariente para
     * el modelo que esta siendo manipulado.
     * @return bool
     */
    public function hasParent();

    /**
     * Cambia el nombre formal del modelo padre.
     * @param string $parentTitle
     * @return void
     */
    public function setParentTitle($parentTitle);

    /**
     * Cambia el nombre identificador del modelo principal.
     * Este identificador es el nombre corto
     * y en plural del modelo, {users},
     * {notes}, {addresses}, etc...
     * @param string $resource
     * @return void
     */
    public function setResource($resource);

    /**
     * Rutas necesarias para manipular al
     * modelo en las vistas y controladores
     * @return \StdClass
     */
    public function getRoutes();

    /**
     * Regresa un objeto generico con todas las
     * variables relacionadas con el modelo.
     * estas variables son las que se encuentran en
     * resource/lang/es/models.php
     * @return \StdClass
     */
    public function getTrans();
}
