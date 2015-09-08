<?php namespace PCI\Database;

use BaseSeeder;

class AuxEntitiesSeeder extends BaseSeeder
{

    /**
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
