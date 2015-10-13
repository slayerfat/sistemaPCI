*******************************************************************
Hola {{$user->name}}!
*******************************************************************
Su {{ trans('models.petitions.singular') }} #{{ $petition->id }}
ha sido creado exitosamente, y ha sido despachado a las partes interesadas.
*******************************************************************
Para ver este {{ trans('models.petitions.singular') }}, Ud.
puede visitar el siguiente enlace: {!! route('petitions.show', $petition->id) !!}
*******************************************************************
@include('emails.petitions.partials.items-plain')
*******************************************************************
{{ $petition->comments }}
*******************************************************************
Mensaje generado el {!! Date::now()->format('l j F Y H:i:s') !!}
*******************************************************************
