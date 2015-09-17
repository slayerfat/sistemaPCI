@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($user, ['route' => 'users.store']) !!}

        <legend>Crear Usuario</legend>

        @include('users.partials.form', ['btnMsg' => 'Crear Usuario'])

        {!! BSForm::close() !!}
    </div>
@stop
