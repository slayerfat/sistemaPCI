@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!!

        BSForm::horizontalModel(
            $user,
            [
                'route' => ['users.update', $user->id],
                'method' => 'PATCH'
            ]
        )

        !!}

        <legend>Editar Cuenta de {{$user->name}}</legend>

        @include('users.partials.form', ['btnMsg' => 'Actualizar Cuenta'])

        {!! BSForm::close() !!}
    </div>
@stop
