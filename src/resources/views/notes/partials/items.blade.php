@unless($note->items->isEmpty())
    <?php

    $array = [];

    foreach ($note->items as $item) {
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
            . trans('models.notes.singular');
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
