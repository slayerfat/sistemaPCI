@extends('partials.pdf.pdf-master')

@section('content')
    <h3>
        Descripción: {{$item->desc}}
    </h3>

    <p>
        Rubro: {{ $item->subCategory->desc }},
        Tipo: {{ $item->type->desc }},
        Fabricante: {{ $item->maker->desc }}.
    </p>

    <p>
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

    <p>
        <?php $reserved = $item->percentageReserved(); ?>
        <?php $stock = abs($reserved - 100); ?>
        <?php $stock = $stock >= 100 ? 0 : $stock ?>
        Reservado:
        @if($reserved == 0)

            {{ "Reservado $reserved% de la existencia." }}

        @elseif($stock == 0)

            {{ "Advertencia reservado $reserved% de la existencia." }}

        @else

            {{ "Existencia de $stock% / $reserved% reservado." }}

        @endif
        Prioridad: {{ $item->priority }},
        Categoría ABC:
        {{ strtoupper($item->asoc) }}
    </p>

    @include('items.pdf.depots')
    @include('items.pdf.movements-table')
@stop
