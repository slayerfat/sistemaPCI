<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface GetModelCollectionInterface
{

    /**
     * Regresa la Coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getModel();

    /**
     * Guarda alguna Coleccion.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     * @param \Illuminate\Database\Eloquent\Collection|null $collection
     * @return void
     */
    public function setModel(Collection $collection);
}
