<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use PCI\Models\AbstractBaseModel;

interface GetModelInterface
{

    /**
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getModel();

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     */
    public function setModel(AbstractBaseModel $model);
}
