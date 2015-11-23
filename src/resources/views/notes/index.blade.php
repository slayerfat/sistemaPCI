@extends('master')

@section('content')

@include('partials.genericTable', [
    'data' => $notes,
    'title' => trans('models.notes.plural'),
    'delete' => false
])

@stop
