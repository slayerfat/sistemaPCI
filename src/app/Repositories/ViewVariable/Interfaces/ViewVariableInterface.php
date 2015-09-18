<?php namespace PCI\Repositories\ViewVariable\Interfaces;

interface ViewVariableInterface
{

    /**
     * Regresa el modelo en json.
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function getUsersGoal();

    /**
     * @return string
     */
    public function getDestView();

    /**
     * @return string
     */
    public function getInitialView();

    /**
     * @return string
     */
    public function getForeignKey();

    /**
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getParent();

    /**
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
     * @param string $parentTitle
     */
    public function setParentTitle($parentTitle);

    /**
     * @param string $resource
     */
    public function setResource($resource);

    /**
     * @return \StdClass
     */
    public function getRoutes();

    /**
     * @return \StdClass
     */
    public function getNames();
}
