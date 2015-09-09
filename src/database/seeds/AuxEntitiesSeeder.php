<?php namespace PCI\Database;

class AuxEntitiesSeeder extends BaseSeeder
{

    public function run()
    {
        $this->command->line('Empezando Seeding de Modelos relacionados con usuario!');

        $data = [
            'PCI\Models\Category' => [
                ['desc' => 'Alimentos'],
                ['desc' => 'Herramientas'],
                ['desc' => 'Primeros Auxilios'],
            ],

            'PCI\Models\Gender' => [
                ['desc' => 'Masculino'],
                ['desc' => 'Femenino']
            ],

            'PCI\Models\ItemType' => [
                ['desc' => 'Perecedero'],
                ['desc' => 'No Perecedero']
            ],
        ];

        $this->seedModels($data);
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
}
