<?php

$array = [];

/** @var \PCI\Models\ItemMovement $movement */
foreach ($item->movements()->latest()->get() as $movement) {
    $number   = $movement->quantity;
    $type     = $movement->stockType->desc;
    $quantity = $item->formattedQuantity($number, $type);
    $quantity = $movement->movement->type->isIn()
        ? $quantity = '+' . $quantity
        : $quantity = '-' . $quantity;
    $array[]  = [
        'uid'        => $movement->movement->id,
        '#'          => $movement->movement->id,
        'Cantidad'   => $quantity,
        'Fecha Vto.' => $movement->due ? $movement->due : '-'
    ];
}
?>

<hr/>

@include('partials.tables.withArray', [
    'data'     => $array,
    'title'    => 'Últimos Movimientos',
    'resource' => 'items',
    'actions'  => false,
    'empty'    => ['Información' => 'Este Item no posee movimientos.']
])
