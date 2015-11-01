*******************************************************************
Hola {{$user->name}}!
*******************************************************************
La {{ trans('models.notes.singular') }} #{{ $note->id }}
relacionada a {{ trans('models.petitions.singular') }} #{{ $petition->id }}
Ha sido creada con éxito.
*******************************************************************
Para ver esta {{ trans('models.notes.singular') }}, Ud.
puede visitar el siguiente enlace:
{!! route('notes.show', $note->id) !!}
*******************************************************************
El documento relacionado ha sido generado y puede descargarlo
en el siguiente enlace:
{!! route('api.notes.pdf', $note->id) !!}
*******************************************************************
Para ver este {{ trans('models.petitions.singular') }}, Ud.
puede visitar el siguiente enlace:
{!! route('petitions.show', $petition->id) !!}
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
