<?php

class AuxEntitiesSeeder extends BaseSeeder
{

    /**
     * @return array
     */
    public static function getModels()
    {
        return [
            PCI\Models\Category::class,
            PCI\Models\Gender::class,
            PCI\Models\ItemType::class,
            PCI\Models\Maker::class,
            PCI\Models\MovementType::class,
            PCI\Models\Nationality::class,
            PCI\Models\NoteType::class,
            PCI\Models\Parish::class,
            PCI\Models\PetitionType::class,
            PCI\Models\Position::class,
            PCI\Models\Profile::class,
            PCI\Models\State::class,
            PCI\Models\SubCategory::class,
            PCI\Models\Town::class,
        ];
    }
}
