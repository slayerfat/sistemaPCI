@extends('partials.pdf.pdf-master')

@section('content')
    <p>
        {{ trans('models.petitions.singular') }}
        #{{ $petition->id }}.
        Creado en: {{ $petition->created_at->toDateString() }}.
    </p>

    <p>
        <i>
            Creado por {{ $petition->user->name }}
            ({{ $petition->user->email }}).
        </i>
    </p>

    <p>
        Status:
        {{
            is_null($petition->status)
            ? 'Por Aprobar.'
            : $petition->status
            ? 'Aprobado.' : 'Rechazado.'
        }}
        Tipo: {{ $petition->type->desc }}
    </p>

    @include('petitions.pdf.items')

    <p>{{ $petition->comments }}</p>
@stop
