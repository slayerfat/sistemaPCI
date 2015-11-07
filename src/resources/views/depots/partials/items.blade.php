@unless($depot->items->isEmpty())
    <?php

    // TODO: sacar de la vista para ViewComposer

    $array = [];

    foreach ($depot->items as $item) {
        // super mamarracho.
        $number   = $item->pivot->quantity;
        $desc     = \PCI\Models\StockType::findOrFail($item->pivot->stock_type_id)->desc;
        $quantity = $item->formattedQuantity($number, $desc);
        $array[]  = [
            'uid'         => $item->id,
            'Descripción' => $item->desc,
            'Cantidad' => $quantity,
        ];
    }

    ?>

    <hr/>

    @include('partials.tables.withArray', [
        'data' => $array,
        'title' => trans('models.items.plural')
            . ' registrados en el '
            . trans('models.depots.singular'),
        'resource' => 'items',
    ])
@endunless
