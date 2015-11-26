@extends('master')

@section('content')
    <div class="container">
        <h1>
            La búsqueda arrojó
            {{ $results->count() }}
            <?php $trans = $results->count() == 1 ? 'singular' : 'plural' ?>
            {{ trans("models.items.$trans") }} como resultado.
        </h1>

        <hr>

        @foreach ($results as $item)
            <h2>
                {!! link_to_route('items.show', $item->desc , $item->slug) !!}
            </h2>

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

            @include('items.partials.stock-progressbar', ['title' => 'Stock'])
            @include('items.partials.reserved-progressbar', [
                'title' => 'Existencia vs Reservaciones'
            ])

            <hr>
        @endforeach
    </div>
@stop
