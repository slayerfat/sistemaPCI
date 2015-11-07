*******************************************************************
Hola {{$user->name}}!
*******************************************************************
Del {{ trans('models.petitions.singular') }} #{{ $petition->id }}
que generó la {{ trans('models.notes.singular') }}
#{{ $note->id }}, desencadenó el
{{ trans('models.movements.singular') }} #{{ $movement->id }}.
*******************************************************************
Para ver este {{ trans('models.petitions.singular') }}, Ud.
puede visitar el siguiente enlace:
{!! route('petitions.show', $petition->id) !!}
*******************************************************************
Para ver esta {{ trans('models.notes.singular') }}, Ud.
puede visitar el siguiente enlace:
{!! route('notes.show', $note->id) !!}
*******************************************************************
El documento relacionado ha sido generado y puede descargarlo
en el siguiente enlace:
{!! route('api.movements.pdf', $movement->id) !!}
*******************************************************************
Detalles del {{ trans('models.movements.singular') }} #{{ $movement->id }}
@include('emails.notes.partials.item-movements-table-plain')
*******************************************************************
Detalles de {{ trans('models.notes.singular') }} #{{ $note->id }}
@include('emails.notes.partials.items-plain')
{{ $note->comments }}
*******************************************************************
Detalles de {{ trans('models.petitions.singular') }} #{{ $petition->id }}
@include('emails.petitions.partials.items-plain')
{{ $petition->comments }}
*******************************************************************
Mensaje generado el {!! Date::now()->format('l j F Y H:i:s') !!}
*******************************************************************
