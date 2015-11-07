<div class="container">
    <?php
    $defaults = ['route' => isset($route) ? $route : "{$resource}.store"];

    if (isset($attributes)) {
        $attributes = array_merge($defaults, $attributes);
    } else {
        $attributes = $defaults;
    }
    ?>
    {!!

    BSForm::horizontalModel(
        $model,
        $attributes
    )

    !!}

    <legend>{{trans("models.{$resource}.create")}}</legend>

    @include("{$resource}.partials.form", ['btnMsg' => trans("models.{$resource}.create")])

    {!! BSForm::close() !!}
</div>

@section('js')
    <script>
        var largeSpinner = new Forms.LargeAjaxSpinner($('body'));
        largeSpinner.onSubmit();
    </script>
    @yield('form-js')
@stop
