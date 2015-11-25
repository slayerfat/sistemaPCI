@extends('partials.pdf.pdf-master')

@section('content')
    <p>
        {{ trans('models.notes.singular') }}
        #{{ $note->id }}.
        La misma, está asociada al
        {{ trans('models.petitions.singular') }}
        #{{ $note->petition->id }}.
    </p>

    <p>
        <i>
            Creado por {{ $note->user->name }}
            ({{ $note->user->email }}),
        </i>
        Dirigido a {{ $note->toUser->name }}
        ({{ $note->toUser->email }}).
    </p>

    <p>
        Status:
        {{
            is_null($note->status)
            ? 'Por Aprobar.'
            : $note->status
            ? 'Aprobado.' : 'Rechazado.'
        }}
        Tipo: {{ $note->type->desc }}
    </p>

    @include('notes.pdf.items')

    <p>{{ $note->comments }}</p>
@stop
