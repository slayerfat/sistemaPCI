@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-edit-model', [
        'model'    => $depot,
        'resource' => 'depots'
    ])
@stop
