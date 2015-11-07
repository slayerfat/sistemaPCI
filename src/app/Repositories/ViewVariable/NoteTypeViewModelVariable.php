<?php namespace PCI\Repositories\ViewVariable;

use PCI\Models\AbstractBaseModel;
use PCI\Models\MovementType;

/**
 * Class NoteTypeViewModelVariable
 * El proposito de esta clase en relacion a las otras ViewVariables es que esta
 * necesita informacion especifica que esta siendo generada en ::init() aparte
 * de mi ignorancia en hacer esto.
 *
 * @package PCI\Repositories\ViewVariable
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteTypeViewModelVariable extends ViewModelVariable
{

    /**
     * Genera una nueva instancia de esta variable.
     * crea la informacion necesaria
     * en la vista.
     *
     * @param AbstractBaseModel $model
     * @param string            $resource
     */
    public function __construct(
        AbstractBaseModel $model,
        $resource = 'noteTypes'
    ) {
        parent::__construct($model, $resource);

        $this->init();
    }

    /**
     * crea las variables necesarias para tener
     * la informacion pertinente en las vistas.
     *
     * @return void
     */
    private function init()
    {
        $this->setParent(MovementType::class);
        $this->setDestView('noteTypes.show');
        $this->setForeignKey('movement_type_id');
        $this->setParentTitle(trans('models.movementTypes.singular'));
    }
}
