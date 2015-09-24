<?php namespace PCI\Repositories\Interfaces;

interface GetByNameOrIdInterface
{

    /**
     * Busca en la base de datos algun modelo
     * que tenga un campo nombre y/o id.
     * @param  string|int $id El identificador (name|id)
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getByNameOrId($id);
}
