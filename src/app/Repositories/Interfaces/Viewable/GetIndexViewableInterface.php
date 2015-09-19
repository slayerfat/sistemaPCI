<?php namespace PCI\Repositories\Interfaces\Viewable;

interface GetIndexViewableInterface
{

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables();
}
