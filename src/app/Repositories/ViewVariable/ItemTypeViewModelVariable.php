<?php namespace PCI\Repositories\ViewVariable;

use BSForm;
use ControlGroup;
use PCI\Models\AbstractBaseModel;

/**
 * Class ItemTypeViewModelVariable
 * El proposito de esta clase en relacion a las otras ViewVariables es que esta
 * necesita informacion especifica que esta siendo generada en ::init() aparte
 * de mi ignorancia en hacer esto.
 *
 * @package PCI\Repositories\ViewVariable
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemTypeViewModelVariable extends ViewModelVariable
{

    /**
     * Genera una nueva instancia de esta variable.
     * crea la informacion necesaria
     * en la vista.
     *
     * @param AbstractBaseModel $model    el modelo relacionado a este
     * @param string            $resource el texto (rutas, vistas, etc)
     */
    public function __construct(
        AbstractBaseModel $model,
        $resource = 'itemTypes'
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
        $field = $this->makePerishableField();
        $this->setDestView('itemTypes.show');
        $this->setFields($field);
    }

    /**
     * @return $this
     */
    private function makePerishableField()
    {
        $model = trans('models.items.plural');
        $list  = [
            0 => 'No',
            1 => 'Si',
        ];

        $field = ControlGroup::generate(
            BSForm::label('perishable', 'Perecible'),
            BSForm::select('perishable', $list, $this->model->perishable),
            BSForm::help("¿Los $model asociados a este, pueden caducar?"),
            2
        );

        return $field;
    }
}
