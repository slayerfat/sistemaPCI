<?php namespace PCI\Repositories\ViewVariable;

use PCI\Models\AbstractBaseModel;
use PCI\Models\Category;

class SubCategoryViewModelVariable extends ViewModelVariable
{

    public function __construct(AbstractBaseModel $model, $resource = 'subCats')
    {

        parent::__construct($model, $resource);

        $this->init();
    }

    /**
     * crea las variables necesarias para tener
     * la informacion pertinente en las vistas.
     */
    private function init()
    {
        $this->setParent(Category::class);
        $this->setDestView('subCats.show');
        $this->setForeignKey('category_id');
        $this->setParentTitle(trans('models.cats.singular'));
    }
}
