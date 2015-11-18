@unless($depot->stocks->isEmpty())
    <?php

    // TODO: sacar de la vista para ViewComposer

    $array = [];

    foreach ($depot->stocks as $stock) {
        /** @var PCI\Models\Stock $stock */
        $item = $stock->item;
        // super mamarracho.
        $number   = $stock->details->sum('quantity');
        $type     = $stock->type->desc;
        $quantity = $item->formattedQuantity($number, $type);
        $array[]  = [
            'uid'         => $item->id,
            'Descripción' => $item->desc,
            'Cantidad'    => $quantity,
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
