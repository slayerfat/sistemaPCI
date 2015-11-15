@foreach($note->items as $item)
------------------------------------
#{{ $item->id }}
Item: {{ $item->desc }}
Stock: {{ $item->formattedStock() }}
Cantidad: {{ $item->pivot->quantity }}
------------------------------------
@endforeach
