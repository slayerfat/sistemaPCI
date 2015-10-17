<?php namespace PCI\Repositories\Interfaces\Note;

use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\RepositoryPaginatorInterface;
use PCI\Repositories\Interfaces\Viewable\GetIndexViewableInterface;

interface NoteRepositoryInterface extends
    ModelRepositoryInterface,
    RepositoryPaginatorInterface,
    GetIndexViewableInterface
{

}
