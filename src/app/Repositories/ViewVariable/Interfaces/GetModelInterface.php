<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use PCI\Models\AbstractBaseModel;

interface GetModelInterface
{

    /**
     * Regresa al modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getModel();

    /**
     * Guarda algun modelo.
     * Por ahora no hace manipulacion/validacion, solo el typehint.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return void
     */
    public function setModel(AbstractBaseModel $model);
}
