@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-edit-model', [
        'model'    => $item,
        'resource' => 'items'
    ])
@stop
