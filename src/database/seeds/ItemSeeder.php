<?php namespace PCI\Database;

use LogicException;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\Note;
use PCI\Models\Petition;

class ItemSeeder extends BaseSeeder
{

    public function run()
    {
        $this->seedItems(10);

        $this->seedPetitions(5);
    }

    /**
     * @param int $quantity
     */
    private function seedItems($quantity)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $this->createModels(Depot::class, $quantity);

        $items = $this->createModels(Item::class, $quantity);

        $items->each(function ($item) {
            $number = rand(1, 10);

            $this->command->info("Uniendo Item {$item->desc} con Depot (id) {$number}");

            /** @var Item $item */
            $item->depots()->attach([$number]);
        });

        $this->command->comment('Terminado ' . __METHOD__);
    }

    /**
     * @param int $quantity
     */
    private function seedPetitions($quantity)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $petitions = $this->createModels(Petition::class, $quantity);

        $petitions->each(function ($petition) {
            foreach (range(0, 2) as $index) {
                $number = $index + rand(1, 8);

                $this->command->info("Uniendo Pedido (id) {$petition->id} con Item (id) {$number}");

                $petition->items()->attach($number);
            }

            $note = $this->createModels(Note::class);

            $petition->notes()->save($note);
        });

        $this->command->comment('Terminado ' . __METHOD__);
    }

    /**
     * Crea en la base de datos y genera objetos de alguna entidad.
     *
     * @param string $class
     * @param int $quantity
     * @return mixed
     * @throws LogicException
     */
    private function createModels($class, $quantity = 1)
    {
        if ($quantity < 1) {
            throw new LogicException('Cantidad no puede ser menor a uno.');
        }

        $items = factory($class, $quantity)->create();

        return $items;
    }
}
