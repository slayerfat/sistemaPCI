<?php

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

if (Auth::user() && Auth::user()->isAdmin()) {
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

echo Navbar::withBrand('sistemaPCI', '/')
    ->withContent(Navigation::links($links))
    ->withContent(
        '<form class="navbar-form navbar-left" role="search">
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Buscar">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        </form>'
    );
