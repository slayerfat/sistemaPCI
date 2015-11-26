@extends('partials.pdf.pdf-master')

@section('content')
    <h3>
        Descripción: {{$item->desc}}
    </h3>

    <p>
        Stock mínimo:
        {{ $item->formattedQuantity($item->minimum, $item->stockType->desc) }}
        Stock:
        {{
        $item->percentageStock() > 100
        ? 'Por encima del 100'
        : $item->percentageStock()
        }}%,
        {{ $item->formattedRealStock() }} En almacenes,
        {{ $item->formattedReserved() }}
        {{ $item->reserved !== 1 ? 'Reservados' : 'Reservado' }}.
    </p>

    @include('items.pdf.depots')
@stop
