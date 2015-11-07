<?php namespace PCI\Listeners\Note;

use PCI\Events\Note\NewItemIngress;

/**
 * Class GenerateItemIngress
 *
 * @package PCI\Listeners\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class GenerateItemIngress extends AbstractItemMovement
{

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewItemIngress $event
     */
    public function handle(NewItemIngress $event)
    {
        $movements = [];
        $data      = $event->data;

        foreach ($event->items as $item) {
            $this->converter->setItem($item);

            $type       = $item->pivot->stock_type_id;
            $quantity   = $item->pivot->quantity;
            $noteAmount = $this->converter->convert($type, $quantity);

            // chequear el stock de cada item
            if ($noteAmount == 0) {
                // TODO: ignorar item en movimientos
                continue;
            }

            // TODO: items perecederos

            $movements[$item->id] = [
                'quantity'      => $quantity,
                'stock_type_id' => $type,
                'due'           => null, // FIXME
            ];

            // se persiste el estado actual del stock
            $depotsWithStock[$data[$item->id]['depot_id']] = [
                'quantity'      => $quantity,
                'stock_type_id' => $type,
            ];

            $this->attachDepots($item, $depotsWithStock);
        }

        $this->setMovement($event->note, $movements);
    }
}
