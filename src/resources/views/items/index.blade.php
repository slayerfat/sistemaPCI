@extends('master')

@section('content')

    @include('partials.genericTable', [
        'data' => $items,
        'title' => trans('models.items.plural'),
        'delete' => false
    ])

@stop
