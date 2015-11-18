{!!

ControlGroup::generate(
    BSForm::label('desc', 'Descripción'),
    BSForm::text('desc'),
    BSForm::help('&nbsp;'),
    2
)

!!}

@if($variables->hasParent())
    {!!

    ControlGroup::generate(
        BSForm::label($variables->getForeignKey(), $variables->getParentTitle()),
        BSForm::select($variables->getForeignKey(), $variables->getParentLists('desc')),
        BSForm::help('&nbsp;'),
        2
    )

    !!}
@endif

@if($variables->hasFields())
    @foreach ($variables->getFields() as $field)
        {!! $field !!}
    @endforeach
@endif

{!! Button::primary($btnMsg)->block()->submit() !!}
