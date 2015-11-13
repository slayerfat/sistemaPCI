<?php

$array = [];

/** @var \PCI\Models\Item $item */
foreach ($item->stocks as $stock) {
// super mamarracho.
    $number   = $stock->details->sum('quantity');
    $type     = $stock->type->desc;
    $quantity = $item->formattedQuantity($number, $type);
    $array[]  = [
        'uid'      => $stock->depot->id,
        'Almacen'  => $stock->depot->number,
        'Anaquel'  => $stock->depot->rack,
        'Alacena'  => $stock->depot->shelf,
        'Cantidad' => $quantity,
    ];
}
?>

<hr/>

@include('partials.tables.withArray', [
    'data' => $array,
    'title' => 'Existencias en los Almacenes',
    'resource' => 'depots',
    'total' => $item->formattedRealStock()
])


