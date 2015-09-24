<?php namespace PCI\Repositories\Interfaces;

interface GetBySlugOrIdInterface
{

    /**
     * Busca en la base de datos algun modelo
     * que tenga un campo slug y/o id.
     * @param  string|int $id El identificador unico (slug|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getBySlugOrId($id);
}
