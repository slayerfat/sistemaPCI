<?php namespace PCI\Database;

class AuxEntitiesSeeder extends BaseSeeder
{

    /**
     * @var array
     */
    private $models;

    /**
     * Es necesario tener los modelos ya listos.
     */
    public function __construct()
    {
        $this->setModels(self::getModels());
    }

    public function run()
    {
        $this->command->info('Empezando Entidades Auxiliares');

        foreach ($this->models as $model) {
            factory($model, 2)->create();
        }
    }

    /**
     * Arreglo de Entidades secundarias
     * o auxiliares en el sistema.
     * Estatico por varias razones, usado en varios lados.
     *
     * @return array
     */
    public static function getModels()
    {
        return [
            'PCI\Models\Category',
            'PCI\Models\Gender',
            'PCI\Models\ItemType',
            'PCI\Models\Maker',
            'PCI\Models\MovementType',
            'PCI\Models\Nationality',
            'PCI\Models\NoteType',
            'PCI\Models\Parish',
            'PCI\Models\PetitionType',
            'PCI\Models\Position',
            'PCI\Models\Profile',
            'PCI\Models\State',
            'PCI\Models\SubCategory',
            'PCI\Models\Town',
        ];
    }

    /**
     * @param array $models
     */
    public function setModels($models)
    {
        $this->models = $models;
    }
}
