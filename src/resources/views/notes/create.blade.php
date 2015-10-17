@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-create-model', [
        'model'    => $note,
        'resource' => 'notes'
    ])
@stop
