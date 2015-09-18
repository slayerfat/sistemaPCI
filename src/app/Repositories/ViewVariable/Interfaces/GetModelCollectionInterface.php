<?php namespace PCI\Repositories\ViewVariable\Interfaces;

interface GetModelCollectionInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getModel();
}
