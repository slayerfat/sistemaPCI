@extends('partials.pdf.pdf-master')

@section('content')
    <h3>
        Descripción: {{$item->desc}}
    </h3>

    @include('items.pdf.movements-table')
@stop
