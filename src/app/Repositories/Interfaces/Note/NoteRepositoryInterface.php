<?php namespace PCI\Repositories\Interfaces\Note;

use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\RepositoryPaginatorInterface;
use PCI\Repositories\Interfaces\Viewable\GetIndexViewableInterface;

interface NoteRepositoryInterface extends
    ModelRepositoryInterface,
    RepositoryPaginatorInterface,
    GetIndexViewableInterface
{

    /**
     * Cambia el estado de la nota.
     *
     * @param int  $id
     * @param bool $status
     * @return bool
     */
    public function changeStatus($id, $status);
}
