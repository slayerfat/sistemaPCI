@extends('master')

@section('content')

    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontal() !!}

        <?php $text = 'Ingresar a ' . trans('defaults.appName') ?>

        <legend>{{$text}}</legend>

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
            BSForm::label('password', 'Contraseña'),
            BSForm::password('password'),
            BSForm::help('&nbsp;'),
            2
        )

        !!}

        {!!
            ControlGroup::generate(
                BSForm::label('control', '&nbsp;'),
                    [
                        [
                            'label' => ['remember', 'Recuerdame'],
                            'input' => ['type' => 'checkbox', 'remember', null]
                        ],
                    ],
                BSForm::help('&nbsp;'),
                2
            )

        !!}

        {!! Button::primary($text)->block()->submit() !!}

        {!! BSForm::close() !!}
    </div>

@stop
