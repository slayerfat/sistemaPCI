<?php
if (!isset($empty)) {
    $empty = ['Información' => 'No hay información que mostrar.'];
}

?>

{!!

Table::withContents([$empty])
    ->striped()

!!}
