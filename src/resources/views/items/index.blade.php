@extends('master')

@section('content')

    @include('partials.genericTable', [
        'data' => $items,
        'title' => trans('models.depots.plural'),
        'delete' => false
    ])

@stop
