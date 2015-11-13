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
            $quantity   = floatval($item->pivot->quantity);
            $date       = $item->pivot->due;
            $noteAmount = $this->converter->convert($type, $quantity);

            // chequear el stock de cada item
            if ($noteAmount == 0) {
                $event->note->comments .= sizeof($event->note->comments) <= 1 ? "" : "\r\n";
                $event->note->comments .= "Se intenta hacer un ingreso del " .
                    "item #{$item->id}, pero la nota asociada tiene una cantidad " .
                    "de cero o nula, ingreso rechazado.";
                $event->note->save();
                // ignora item en movimientos
                continue;
            }

            $movements[$item->id] = [
                'quantity'      => $quantity,
                'stock_type_id' => $type,
                'due'           => $date,
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
