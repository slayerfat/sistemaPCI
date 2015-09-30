@extends('master')

@section('content')
    <div class="container">
        <h1>
            Item {{$item}}

            @include(
                'partials.buttons.edit-delete',
                ['resource' => 'items', 'id' => $item->id]
            )
        </h1>
    </div>
@stop
