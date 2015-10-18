@foreach($note->items as $item)
    ------------------------------------
    #{{ $item->id }}
    Item: {{ $item->desc }}
    Stock disponible: {{ $item->formattedStock() }}
    Cantidad solicitada: {{ $item->pivot->quantity }}
    ------------------------------------
@endforeach
