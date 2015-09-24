<?php namespace PCI\Repositories\Interfaces\Misc;

interface FindParentInterface
{

    /**
     * Busca al padre relacionado directamente con
     * este modelo, si existen varios padres,
     * entonces se devuelve el mas importante
     * en contexto al repositorio.
     * @param string|int $id El identificador unico (name|slug|int).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function findParent($id);
}
