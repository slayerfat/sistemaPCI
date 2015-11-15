<?php namespace PCI\Listeners\Note;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use PCI\Events\Note\NewItemIngress;
use PCI\Models\Stock;
use PCI\Models\StockDetail;

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
     * @var int|string
     */
    private $type;

    /**
     * @var float
     */
    private $quantity;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \PCI\Models\Note
     */
    private $note;

    /**
     * @var \Carbon\Carbon|string
     */
    private $date;

    /**
     * @var Collection
     */
    private $data;

    /**
     * @var \PCI\Models\Item
     */
    private $item;

    /**
     * Handle the event.
     *
     * @param \PCI\Events\Note\NewItemIngress $event
     */
    public function handle(NewItemIngress $event)
    {
        $this->data = $event->data;
        $this->note = $event->note;
        $lastDate   = $lastId = null;

        foreach ($event->items as $item) {
            $this->date = $item->type->perishable
                ? $item->pivot->due
                : null;
            if ($lastId == $item->id && $lastDate == $this->date) {
                continue;
            }

            $this->converter->setItem($item);
            $this->item     = $item;
            $this->type     = $item->pivot->stock_type_id;
            $this->quantity = floatval($item->pivot->quantity);
            $this->amount   = $this->converter->convert($this->type, $this->quantity);
            $lastDate       = $this->date;
            $lastId         = $item->id;

            // chequear el stock de cada item
            if ($this->amount == 0) {
                $this->note->comments .= sizeof($this->note->comments) <= 1 ? "" : "\r\n";
                $this->note->comments .= "Se intenta hacer un ingreso del " .
                    "item #{$item->id}, pero la nota asociada tiene una cantidad " .
                    "de cero o nula, ingreso rechazado.";
                $this->note->save();
                // ignora item en movimientos
                continue;
            }

            $this->getStockCollection();
        }
    }

    private function getStockCollection()
    {
        $results = $this->sortCollection();

        foreach ($results as $array) {
            $stock = $this->item
                ->stocks()
                ->where('depot_id', $array['depot_id'])
                ->first();

            if (is_null($stock)) {
                $stock                = new Stock;
                $stock->depot_id      = $array['depot_id'];
                $stock->stock_type_id = $this->type;
                $this->item->stocks()->save($stock);
            }

            $details = $this->getStockDetails($stock, $array);

            $stock->details()->save($details);
        }
    }

    /**
     * @return Collection
     */
    private function sortCollection()
    {
        /** @var Collection $results */
        $results  = $this->data[$this->item->id]->unique();
        $filtered = $results->filter(function ($set) {
            return $set['due'] == $this->date;
        });

        $this->data[$this->item->id]->forget($filtered->keys()->all());

        return $filtered;
    }

    /**
     * @param Stock $stock
     * @param array $array
     * @return \PCI\Models\StockDetail
     */
    private function getStockDetails(Stock $stock, array $array)
    {
        if ($stock->details->isEmpty()) {
            return new StockDetail([
                'quantity' => $array['amount'],
                'due'      => $array['due'],
            ]);
        }

        $details = $this->getDetails($stock, $array);

        if ($details->count() > 1) {
            $total = $details->sum('quantity') + $array['amount'];

            $details->each(function (StockDetail $detail) {
                $detail->delete();
            });

            return new StockDetail([
                'quantity' => $total,
                'due'      => $array['due'],
            ]);
        } elseif ($details->count() == 0) {
            return new StockDetail([
                'quantity' => $array['amount'],
                'due'      => $array['due'],
            ]);
        }

        /** @var StockDetail $details */
        $details = $details->first();
        $details->quantity += $array['amount'];

        return $details;
    }

    /**
     * @param \PCI\Models\Stock $stock
     * @param array             $array
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function getDetails(Stock $stock, array $array)
    {
        $date = $array['due'] ? Carbon::parse($array['due']) : null;

        $details = $stock->details()
            ->where('due', $date)
            ->get();

        return $details;
    }
}
