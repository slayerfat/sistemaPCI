<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface GetModelCollectionInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getModel();

    /**
     * @param \Illuminate\Database\Eloquent\Collection|null $model
     */
    public function setModel(Collection $model);
}
