<?php namespace PCI\Repositories\ViewVariable\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface GetModelCollectionInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getModel();

    /**
     * @param \Illuminate\Database\Eloquent\Collection|null $collection
     * @return void
     */
    public function setModel(Collection $collection);
}
