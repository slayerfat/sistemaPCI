@extends('master')

@section('content')

    @include('partials.genericTable', [
        'data' => $petitions,
        'title' => trans('models.petitions.plural'),
        'delete' => true
    ])

@stop
