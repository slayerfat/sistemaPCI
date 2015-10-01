<div class="container">
    {!!

    BSForm::horizontalModel(
        $model,
        [
            'route' => isset($route) ? $route : "{$resource}.store"
        ]
    )

    !!}

    <legend>{{trans("models.{$resource}.create")}}</legend>

    @include("{$resource}.partials.form", ['btnMsg' => trans("models.{$resource}.create")])

    {!! BSForm::close() !!}
</div>
