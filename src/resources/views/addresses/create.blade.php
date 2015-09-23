@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!! BSForm::horizontalModel($address, ['route' => ['addresses.store', $employee->id]]) !!}

        <legend>{{trans('models.addresses.create')}}</legend>

        @include('addresses.partials.form', ['btnMsg' => trans('models.addresses.create')])

        {!! BSForm::close() !!}
    </div>
@stop

@section('js')
    <script src="{!!elixir('js/getAddress.js')!!}"></script>
@stop
