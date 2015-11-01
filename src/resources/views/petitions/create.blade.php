@extends('master')

@section('content')
    @include('partials.errors')

    @include('partials.forms.horizontal-create-model', [
        'model'    => $petition,
        'resource' => 'petitions',
        'attributes' => ['id' => 'large-ajax-form']
    ])
@stop
