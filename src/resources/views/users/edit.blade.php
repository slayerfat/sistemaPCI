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

        <legend>{{trans('models.users.edit')}}</legend>

        @include('users.partials.form', ['btnMsg' => trans('models.users.edit')])

        {!! BSForm::close() !!}
    </div>
@stop
