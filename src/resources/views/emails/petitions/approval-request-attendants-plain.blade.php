*******************************************************************
El usuario {{$user->name}} {{ $user->email }}
*******************************************************************
Ha solicitado la aprobación del
{{ trans('models.petitions.singular') }} #{{ $petition->id }}.
*******************************************************************
Este {{ trans('models.petitions.singular') }}
fue generado {{ $petition->created_at->diffForHumans()  }}.
*******************************************************************
Para ver este {{ trans('models.petitions.singular') }},
Ud. puede visitar el siguiente enlace:
{!! route('petitions.show', $petition->id) !!}
*******************************************************************
@include('emails.petitions.partials.items-plain')
*******************************************************************
{{ $petition->comments }}
*******************************************************************
Mensaje generado el {!! Date::now()->format('l j F Y H:i:s') !!}
*******************************************************************

