<?php

// enlaces de usuario general
$links = [
    [
        'link'  => '#',
        'title' => 'Pedidos'
    ],
    [
        'link'  => '#',
        'title' => 'Notas'
    ],
    [
        'Items',
        [
            [
                'link'  => '#',
                'title' => 'Crear'
            ],
            [
                'link'  => '#',
                'title' => 'Consultar'
            ],
            Navigation::NAVIGATION_DIVIDER,
            [
                'link'  => '#',
                'title' => '...'
            ],
        ]
    ],
];

// enlaces de mantenimiento (administrador)
if (auth()->user() && auth()->user()->isAdmin()) {
    $links[] = [
        'Mant.',
        [
            [
                'link'  => '#',
                'title' => 'Crear Usuario'
            ],
            [
                'link'  => '#',
                'title' => 'Consultar Usuarios'
            ],
            Navigation::NAVIGATION_DIVIDER,
            [
                'link'  => '#',
                'title' => 'Crear Perfil'
            ],
            [
                'link'  => '#',
                'title' => 'Consultar Perfiles'
            ],
        ]
    ];
}

if (auth()->guest()) {
    $rightLinks = [
        [
            'link'  => route('auth.getLogin'),
            'title' => 'Entrar'
        ],
        [
            'link'  => route('auth.getRegister'),
            'title' => 'Registrarse'
        ],
    ];
} else {
    $rightLinks = [
        [
            "Hola ".auth()->user()->name,
            [
                [
                    'link'  => '#', //route('users.show', auth()->user()->name)
                    'title' => 'Ver Perfil'
                ],
                [
                    'link'  => route('auth.getLogout'),
                    'title' => 'Salir'
                ],
            ]
        ]
    ];
}

$searchBox = <<<'HTML'
<form class="navbar-form navbar-left" role="search">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Buscar">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
HTML;

echo Navbar::withBrand('sistemaPCI', '/')
    ->withContent(Navigation::links($links))
    ->withContent($searchBox)
    ->withContent(Navigation::links($rightLinks)->right());
