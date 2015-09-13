@extends('master')

@section('content')

    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontal() !!}

        <legend>Registrarse en {!! trans('defaults.appName') !!}</legend>

        {!!

        ControlGroup::generate(
            BSForm::label('name', 'Seudónimo'),
            BSForm::text('name'),
            BSForm::help('Este seudónimo debe ser unico en el sistema.'),
            2
        )

        !!}

        {!!

        ControlGroup::generate(
            BSForm::label('email', 'Correo Electrónico'),
            BSForm::text('email'),
            BSForm::help('Por favor introduzca un correo electronico valido.'),
            2
        )

        !!}

        {!!

        ControlGroup::generate(
            BSForm::label('password', 'Contraseña'),
            BSForm::text('password'),
            BSForm::help('Por favor la contraseña debe ser al menos 6 caracteres.'),
            2
        )

        !!}

        {!!

        ControlGroup::generate(
            BSForm::label('password_confirmation', 'Confirmar Contraseña'),
            BSForm::text('password_confirmation'),
            BSForm::help('Reintroduzca la contraseña.'),
            2
        )

        !!}

        {!! Button::primary('Registrarse en el sistemaPCI')->block()->submit() !!}

        {!! BSForm::close() !!}
    </div>

@stop
