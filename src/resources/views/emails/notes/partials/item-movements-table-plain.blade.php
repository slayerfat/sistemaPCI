{{--se hace sin identacion para que sea mostrado correctamente--}}
@foreach($note->movements as $movement)
@foreach($movement->itemMovements as $details)
------------------------------------
#{{ $details->item->id }}
Item: {{ $details->item->desc }}
@if($movement->type->isIn())
Fecha Vencimiento: {{ $details->due or 'Sin fecha.' }}
{{ $details->due ? $details->due->diffForHumans() : null }}
Cantidad: +{{ $details->quantity }}
@else
Cantidad: -{{ $details->quantity }}
@endif
Stock: {{ $details->item->formattedStock() }}
------------------------------------
@endforeach
@endforeach
