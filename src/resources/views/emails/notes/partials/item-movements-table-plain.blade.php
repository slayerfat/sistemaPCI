{{--se hace sin identacion para que sea mostrado correctamente--}}
@foreach($note->movements as $movement)
@foreach($movement->items as $item)
------------------------------------
#{{ $item->id }}
Item: {{ $item->desc }}
@if($movement->type->isIn())
Cantidad: +{{ $item->pivot->quantity }}
@else
Cantidad: +{{ $item->pivot->quantity }}
@endif
Stock: {{ $item->formattedStock() }}
------------------------------------
@endforeach
@endforeach
