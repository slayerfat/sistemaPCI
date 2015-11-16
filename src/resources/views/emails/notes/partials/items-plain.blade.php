@foreach($note->items as $item)
------------------------------------
#{{ $item->id }}
Item: {{ $item->desc }}
Stock: {{ $item->formattedStock() }}
@if($note->type->movementType->isIn())
Cantidad: +{{ $item->pivot->quantity }}
Fecha Vencimiento: {{ $item->pivot->due or 'Sin fecha.' }}
@else
Cantidad: -{{ $item->pivot->quantity }}
@endif
------------------------------------
@endforeach
