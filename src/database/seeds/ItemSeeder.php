<?php namespace PCI\Database;

use LogicException;
use PCI\Models\Depot;
use PCI\Models\Item;
use PCI\Models\Movement;
use PCI\Models\Note;
use PCI\Models\Petition;

class ItemSeeder extends BaseSeeder
{

    public function run()
    {
        $this->seedItems(10);

        $this->seedPetitions(5);

        $this->seedMovements(2);
    }

    /**
     * @param int $quantity
     */
    private function seedItems($quantity)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $this->createModels(Depot::class, $quantity);

        $items = $this->createModels(Item::class, $quantity);

        $items->each(function ($item) use ($quantity) {
            $number = $this->getRand(1, $quantity);

            $this->command->info("Uniendo Item {$item->desc} con Depot (id) {$number}");

            /** @var Item $item */
            $item->depots()->attach([$number]);
        });

        $item = $items->random();

        $this->seedItemDependency($quantity, $item);
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
                $number = $index + $this->getRand(1, 8);

                $this->command->info("Uniendo Pedido (id) {$petition->id} con Item (id) {$number}");

                $petition->items()->attach($number, ['quantity' => $number]);
            }

            $note = $this->createModels(Note::class);

            $petition->notes()->save($note);
        });
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

    /**
     * @param int $quantity
     */
    private function seedMovements($quantity)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $movements = $this->createModels(Movement::class, $quantity);

        $movements->each(function ($movement) {
            $number = $this->getRand(5, 20);

            $this->command->info("Uniendo Movimiento (id) {$movement->id} con Item (id) 1: cantidad: {$number}");

            $movement->items()->attach(1, ['quantity' => $number]);
        });
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    private function getRand($min = 1, $max = 5)
    {
        return rand($min, $max);
    }

    /**
     * @param int $quantity
     * @param Item $item
     */
    private function seedItemDependency($quantity, $item)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        do {
            $number = $this->getRand(1, $quantity);
        } while ($number == $item->id);

        $this->command->info(
            'Uniendo Item '
            . $item->desc
            . " (id) {$item->id}, con "
            . "Item ~dependencia~ (id) {$number}"
        );

        $item->dependsOn()->attach($number);
    }
}
