*******************************************************************
El usuario {{$user->name}} {{ $user->email }}
*******************************************************************
Ha creado el {{ trans('models.petitions.singular') }} #{{ $petition->id }}
*******************************************************************
Para ver este {{ trans('models.petitions.singular') }},
Ud. puede visitar el siguiente enlace:
{!! route('petitions.show', $petition->id) !!}
*******************************************************************
@include('emails.petitions.partials.items-plain')
*******************************************************************
Mensaje generado el {!! Date::now()->format('l j F Y H:i:s') !!}
*******************************************************************

