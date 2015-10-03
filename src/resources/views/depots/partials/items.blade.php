@unless($depot->items->isEmpty())
    <?php

    $array = [];

    foreach ($depot->items as $item) {
        // super mamarracho.
        $number = $item->pivot->quantity;

        $quantity = $item->formattedQuantity($number);

        $array[] = [
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
