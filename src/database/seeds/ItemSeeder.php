<?php namespace PCI\Database;

use LogicException;
use PCI\Models\Item;
use PCI\Models\ItemMovement;
use PCI\Models\Movement;
use PCI\Models\Note;
use PCI\Models\Petition;
use PCI\Models\Stock;

/**
 * Class ItemSeeder
 *
 * @package PCI\Database
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemSeeder extends AbstractSeeder
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

        $stocks = $this->createModels(Stock::class, $quantity);

        // para probar la dependencia de item con item
        /** @var Item $item */
        $item = Item::findOrFail($this->getRand(1, $quantity));

        $this->seedItemDependency($quantity, $item);
    }

    /**
     * Crea en la base de datos y genera objetos de alguna entidad.
     *
     * @param string $class
     * @param int    $quantity
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

    /**
     * @param int $quantity
     */
    private function seedPetitions($quantity)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $petitions = $this->createModels(Petition::class, $quantity);

        $petitions->each(function ($petition) {
            /** @var \PCI\Models\Petition $petition */
            foreach (range(0, 2) as $index) {
                $number = $index + $this->getRand(1, 8);

                $this->command->info("Uniendo Pedido (id) {$petition->id} con Item (id) {$number}");

                $petition->items()->attach($number, [
                    'quantity'      => $number,
                    'stock_type_id' => $this->getRand(1, 3),
                ]);
            }

            $note = $this->createModels(Note::class);

            $petition->notes()->save($note);
        });
    }

    /**
     * @param int $quantity
     */
    private function seedMovements($quantity)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $movement = factory(Movement::class)->create();

        Stock::all()->each(function ($stock) use ($movement) {
            $number = $this->getRand(5, 20);

            $itemMovement = factory(ItemMovement::class)->create([
                'stock_id' => $stock->id,
            ]);

            $movement->itemMovements()->save($itemMovement);
        });
    }
}
