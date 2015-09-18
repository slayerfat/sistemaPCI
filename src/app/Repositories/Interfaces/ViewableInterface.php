<?php namespace PCI\Repositories\Interfaces;

interface ViewableInterface
{

    /**
     * regresa la informacion necesaria para generar la vista.
     * esta necesita el destino y el nombre de
     * la variable para el Model Binding.
     * @return \PCI\Repositories\ViewVariables
     */
    public function getCreateViewVariables();
}
