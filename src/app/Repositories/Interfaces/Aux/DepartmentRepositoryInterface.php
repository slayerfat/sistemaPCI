<?php namespace PCI\Repositories\Interfaces\Aux;

use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\Viewable\ViewableInterface;
use PCI\Repositories\Interfaces\GetBySlugOrIdInterface;

interface DepartmentRepositoryInterface extends ModelRepositoryInterface, ViewableInterface, GetBySlugOrIdInterface
{

}
