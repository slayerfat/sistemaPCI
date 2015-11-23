{!!

ControlGroup::generate(
    BSForm::label('name', 'Seudónimo'),
    BSForm::text('name'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('email', 'Correo Electrónico'),
    BSForm::text('email'),
    BSForm::help('&nbsp;'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('password', 'Contraseña'),
    BSForm::password('password'),
    BSForm::help('Por favor la contraseña debe ser al menos 6 caracteres.'),
    2
)

!!}

{!!

ControlGroup::generate(
    BSForm::label('password_confirmation', 'Confirmar Contraseña'),
    BSForm::password('password_confirmation'),
    BSForm::help('&nbsp;'),
    2
)

!!}

@if(Auth::user()->isAdmin() and $user->id != Auth::id() and !$user->isAdmin())

    {!!

    ControlGroup::generate(
        BSForm::label('profile_id', 'Perfil'),
        BSForm::select('profile_id', $profiles),
        BSForm::help('&nbsp;'),
        2
    )

    !!}

@endif

{!! Button::primary($btnMsg)->block()->submit() !!}
