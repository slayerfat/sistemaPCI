<?php namespace PCI\Repositories\ViewVariable;

use PCI\Models\AbstractBaseModel;
use PCI\Models\Category;

/**
 * Class SubCategoryViewModelVariable
 * @package PCI\Repositories\ViewVariable
 * El proposito de esta clase en relacion a las otras
 * ViewVariables es que la subcategoria necesita
 * informacion especifica que esta siendo
 * generada en ::init() aparte de
 * mi ignorancia en hacer esto.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class SubCategoryViewModelVariable extends ViewModelVariable
{

    /**
     * Genera una nueva instancia de esta variable.
     * crea la informacion necesaria
     * en la vista de rubros.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource
     */
    public function __construct(AbstractBaseModel $model, $resource = 'subCats')
    {

        parent::__construct($model, $resource);

        $this->init();
    }

    /**
     * crea las variables necesarias para tener
     * la informacion pertinente en las vistas.
     * @return void
     */
    private function init()
    {
        $this->setParent(Category::class);
        $this->setDestView('subCats.show');
        $this->setForeignKey('category_id');
        $this->setParentTitle(trans('models.cats.singular'));
    }
}
