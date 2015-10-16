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
