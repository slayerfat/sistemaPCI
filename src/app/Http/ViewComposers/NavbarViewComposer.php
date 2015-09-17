<?php namespace PCI\Http\ViewComposers;

use PCI\Models\User;
use Illuminate\View\View;
use Illuminate\Auth\Guard;
use Bootstrapper\Navigation;

class NavbarViewComposer
{

    /**
     * @var User
     */
    private $user;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    public function compose(View $view)
    {
        // enlaces de usuario general
        $links = $this->getLeftLinks();

        // enlaces de usuario al lado derecho
        $rightLinks = $this->getRightLinks();

        // busquedas
        $searchBox = '<form class="navbar-form navbar-left hidden-sm" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Indique su busqueda">
                            </div>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        </form>';

        $view->with(compact('links', 'rightLinks', 'searchBox'));
    }

    /**
     * @return array
     */
    private function getRightLinks()
    {
        if (is_null($this->user)) {
            return [
                [
                    'link'  => route('auth.getLogin'),
                    'title' => 'Entrar'
                ],
                [
                    'link'  => route('auth.getRegister'),
                    'title' => 'Registrarse'
                ],
            ];
        }

        return [
            [
                "Hola " . $this->user->name,
                [
                    [
                        'link'  => route('users.show', $this->user->name),
                        'title' => trans('defaults.users.show')
                    ],
                    [
                        'link'  => route('auth.getLogout'),
                        'title' => 'Salir'
                    ],
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function getLeftLinks()
    {
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
        if ($this->user && $this->user->isAdmin()) {
            $links[] = [
                'Mant.',
                [
                    [
                        'link'  => route('users.create'),
                        'title' => trans('defaults.users.create')
                    ],
                    [
                        'link'  => route('users.index'),
                        'title' => trans('defaults.users.index')
                    ],
                    Navigation::NAVIGATION_DIVIDER,
                    [
                        'link'  => '#',
                        'title' => trans('defaults.profiles.create')
                    ],
                    [
                        'link'  => '#',
                        'title' => trans('defaults.profiles.index')
                    ],
                    Navigation::NAVIGATION_DIVIDER,
                    [
                        'link'  => route('cats.create'),
                        'title' => trans('defaults.cats.create')
                    ],
                    [
                        'link'  => route('cats.index'),
                        'title' => trans('defaults.cats.index')
                    ],
                ]
            ];

            return $links;
        }

        return $links;
    }
}
