@extends('master')

@section('content')
    @include('partials.errors')

    <div class="container">
        {!!

            BSForm::horizontalModel(
                $address,
                [
                    'route' => ['addresses.update', $address->id],
                    'method' => 'PATCH'
                ]
            )

        !!}

        <legend>{{trans('models.addresses.edit')}}</legend>

        @include('addresses.partials.form', ['btnMsg' => trans('models.addresses.edit')])

        {!! BSForm::close() !!}
    </div>
@stop

@section('js')
    <script src="{!!elixir('js/setAddress.js')!!}"></script>
@stop


