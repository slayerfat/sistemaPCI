{!!

ControlGroup::generate(
    BSForm::label('name', '&nbsp;'),
    BSForm::text('name'),
    BSForm::help('&nbsp;'),
    2
)

!!}


{!! Button::primary($btnMsg)->block()->submit() !!}
