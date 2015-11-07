@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-create-model', [
        'model'    => $note,
        'resource' => 'notes',
        'attributes' => ['id' => 'large-ajax-form'],
        'spinner' => true
    ])
@stop
