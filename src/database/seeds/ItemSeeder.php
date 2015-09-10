<?php namespace PCI\Database;

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

        factory(Depot::class, $quantity)->create();

        $items = factory(Item::class, $quantity)->create();

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

        $petitions = factory(Petition::class, $quantity)->create();

        $petitions->each(function ($petition) {
            foreach (range(0, 2) as $index) {
                $number = $index + rand(1, 8);

                $this->command->info("Uniendo Pedido (id) {$petition->id} con Item (id) {$number}");

                $petition->items()->attach($number);
            }

            $note = factory(Note::class)->create();

            $petition->notes()->save($note);
        });

        $this->command->comment('Terminado ' . __METHOD__);
    }
}
