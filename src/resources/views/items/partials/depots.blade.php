<?php

$array = [];

foreach ($item->depots as $depot) {
    $array[] = [
        'uid'      => $depot->id,
        'Almacen'  => $depot->number,
        'Anaquel'  => $depot->rack,
        'Alacena'  => $depot->shelf,
        'Cantidad' => $depot->pivot->quantity,
    ];
}

?>

<hr/>

@include('partials.tables.withArray', [
    'data' => $array,
    'title' => 'Existencias en los Almacenes',
    'resource' => 'depots',
    'total' => $item->stock
])


