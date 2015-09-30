@extends('master')

@section('content')
    <div class="container">
        <h1>
            Almacen {{$item}}

            @include(
                'partials.buttons.edit-delete',
                ['resource' => 'depots', 'id' => $item->id]
            )
        </h1>
    </div>
@stop
