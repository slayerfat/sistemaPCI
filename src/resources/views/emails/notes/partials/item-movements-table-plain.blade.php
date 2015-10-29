@foreach($note->movements as $movement)
    @foreach($movement->items as $item)
        ------------------------------------
        #{{ $item->id }}
        Item: {{ $item->desc }}
        Stock: {{ $item->formattedStock() }}
        @if($movement->type->isIn())
            Cantidad: +{{ $item->pivot->quantity }}
        @else
            Cantidad: +{{ $item->pivot->quantity }}
        @endif
        ------------------------------------
    @endforeach
@endforeach
