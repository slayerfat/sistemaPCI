<?php

$array = [];

foreach ($item->depots as $depot) {
    // super mamarracho.
    $number   = $depot->pivot->quantity;
    $type     = \PCI\Models\StockType::whereId($depot->pivot->stock_type_id)->firstOrFail();
    $quantity = $item->formattedQuantity($number, $type->desc);
    $array[]  = [
        'uid'      => $depot->id,
        'Almacen'  => $depot->number,
        'Anaquel'  => $depot->rack,
        'Alacena'  => $depot->shelf,
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


