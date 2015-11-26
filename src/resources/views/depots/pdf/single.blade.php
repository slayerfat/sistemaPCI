@extends('partials.pdf.pdf-master')

@section('content')
    <h3>
        {{ trans('models.depots.singular') }}
        {{ $depot->number }}
    </h3>

    <p>
        Administrado por:
        {{ $depot->owner->name }}
        ({{ $depot->owner->email }}).
    </p>

    <p>
        Anaquel {{$depot->rack}}, Alacena {{$depot->shelf}}
    </p>

    @include('depots.pdf.items')
@stop
