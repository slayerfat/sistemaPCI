@unless($petition->items->isEmpty())
    <?php

    // TODO: sacar de la vista para ViewComposer

    $array = [];

    foreach ($petition->items as $item) {
        // super mamarracho.
        $number = $item->pivot->quantity;
        $desc = \PCI\Models\StockType::findOrFail($item->pivot->stock_type_id)->desc;
        $quantity = $item->formattedQuantity($number, $desc);

        $array[] = [
            'uid'         => $item->id,
            'Descripción' => $item->desc,
            'Cantidad'    => $quantity,
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
