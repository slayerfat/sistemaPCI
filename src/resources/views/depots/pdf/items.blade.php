@if(!$depot->stocks->isEmpty())
    <?php

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
        'actions' => false
    ])
@else
    @include('partials.tables.empty-data-set', ['empty' => ['Información' => 'este Almacén no tiene Items asociados.']])
@endif
