<?php

$array = [];

foreach ($item->depots as $depot) {
    $array[] = [
        'uid'      => $depot->id,
        'Almacen'  => $depot->number,
        'Anaquel'  => $depot->rack,
        'Alacena'  => $depot->shelf,
        'Cantidad' => $depot->pivot, //FIXME a espera de #35 en github
    ];
}

?>

<hr/>

@include('partials.tables.withArray', [
    'data' => $array,
    'title' => 'Existencias en los Almacenes',
    'resource' => 'depots'
])


