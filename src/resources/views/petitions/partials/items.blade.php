@unless($petition->items->isEmpty())
    <?php

    $array = [];

    foreach ($petition->items as $item) {
        // super mamarracho.
        $number = $item->pivot->quantity;

        $quantity = $item->formattedQuantity($number);

        $array[] = [
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
            . trans('models.petitions.singular'),
        'resource' => 'items',
    ])
@endunless
