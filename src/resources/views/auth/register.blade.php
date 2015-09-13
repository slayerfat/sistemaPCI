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
            BSForm::help('&nbsp;'),
            2
        )

        !!}

        {!!

        ControlGroup::generate(
            BSForm::label('email', 'Correo Electrónico'),
            BSForm::text('email'),
            BSForm::help('&nbsp;'),
            2
        )

        !!}

        {!!

        ControlGroup::generate(
            BSForm::label('password', 'Contraseña'),
            BSForm::password('password'),
            BSForm::help('Por favor la contraseña debe ser al menos 6 caracteres.'),
            2
        )

        !!}

        {!!

        ControlGroup::generate(
            BSForm::label('password_confirmation', 'Confirmar Contraseña'),
            BSForm::password('password_confirmation'),
            BSForm::help('&nbsp;'),
            2
        )

        !!}

        {!! Button::primary('Registrarse en el sistemaPCI')->block()->submit() !!}

        {!! BSForm::close() !!}
    </div>
@stop
