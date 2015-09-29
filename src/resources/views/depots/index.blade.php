@extends('master')

@section('content')

    @include('partials.genericTable', [
        'data' => $depots,
        'title' => trans('models.depots.plural'),
        'delete' => true
    ])

@stop
