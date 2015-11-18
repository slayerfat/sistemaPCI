@foreach($petition->items as $item)
------------------------------------
#{{ $item->id }}
Item: {{ $item->desc }}
Stock: {{ $item->formattedStock() }}
@if($petition->type->movementType->isIn())
Cantidad: +{{ $item->pivot->quantity }}
@else
Cantidad: -{{ $item->pivot->quantity }}
@endif
------------------------------------
@endforeach
