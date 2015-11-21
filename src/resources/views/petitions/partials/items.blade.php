@unless($petition->items->isEmpty())
    <?php

    // TODO: sacar de la vista para ViewComposer

    $array = [];

    /** @var \PCI\Models\Item $item */
    foreach ($petition->items as $item) {
        // super mamarracho.
        $number   = $item->pivot->quantity;
        $id       = $item->pivot->stock_type_id;
        $desc     = \PCI\Models\StockType::findOrFail($id, ['desc'])->desc;
        $quantity = $item->formattedQuantity($number, $desc);

        $array[] = [
            'uid'         => $item->id,
            'Descripción' => $item->desc,
            'Cantidad'    => $quantity,
            'Existencia'  => $item->formattedRealStock(),
            'Reservado'   => $item->formattedReserved(),
            'Ajustado'    => $item->formattedStock(),
        ];
    }

    if (isset($title)) {
        $title = trans('models.items.plural')
            . ' registrados en el '
            . trans('models.petitions.singular');
    } else {
        $title = null;
    }

    ?>

    <hr/>

    @include('partials.tables.withArray', [
        'data' => $array,
        'title' => $title,
        'resource' => 'items',
    ])
@endunless
