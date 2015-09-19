<?php namespace PCI\Repositories\Interfaces;

use PCI\Repositories\Interfaces\Viewable\ViewableInterface;

interface CategoryRepositoryInterface extends ModelRepositoryInterface, ViewableInterface, GetBySlugOrIdInterface
{

}
