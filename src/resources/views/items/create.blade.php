@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-create-model', [
        'model'    => $item,
        'resource' => 'items'
    ])
@stop
