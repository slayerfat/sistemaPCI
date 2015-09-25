{!!

ControlGroup::generate(
    BSForm::label('first_name', 'Primer nombre'),
    BSForm::text('first_name'),
    BSForm::help('&nbsp;'),
    3
)

!!}

{!! Button::primary($btnMsg)->block()->submit() !!}
