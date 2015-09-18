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
        BSForm::select($variables->getForeignKey(), $variables->getParentLists('name')),
        BSForm::help('&nbsp;'),
        2
    )

    !!}
@endif

{!! Button::primary($btnMsg)->block()->submit() !!}
