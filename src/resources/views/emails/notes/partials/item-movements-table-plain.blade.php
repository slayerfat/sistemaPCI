{{--se hace sin identacion para que sea mostrado correctamente--}}
@foreach($note->movements as $movement)
@foreach($movement->itemMovements as $details)
<?php
$pivot = $details->item->notes()->whereNoteId($note->id)->first()->pivot;
?>
------------------------------------
#{{ $details->item->id }}
Item: {{ $details->item->desc }}
Fecha Vencimiento: {{ $pivot->due }}
{{ Date::parse($pivot->due)->diffForHumans() }}
@if($movement->type->isIn())
Cantidad: +{{ $pivot->quantity }}
@else
Cantidad: +{{ $pivot->quantity }}
@endif
Stock: {{ $details->item->formattedStock() }}
------------------------------------
@endforeach
@endforeach
