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

    /**
     * @param \Illuminate\View\View $view
     * @return void
     */
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
                        'title' => trans('models.users.show')
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
            return $this->makeAdminLinks($links);
        }

        return $links;
    }

    /**
     * @param $links
     * @return array
     */
    private function makeAdminLinks($links)
    {
        $links[] = [
            'Mant.',
            [
                [
                    'link'  => route('users.create'),
                    'title' => trans('models.users.create')
                ],
                [
                    'link'  => route('users.index'),
                    'title' => trans('models.users.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => '#',
                    'title' => trans('aux.profiles.create')
                ],
                [
                    'link'  => '#',
                    'title' => trans('aux.profiles.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('cats.create'),
                    'title' => trans('aux.cats.create')
                ],
                [
                    'link'  => route('cats.index'),
                    'title' => trans('aux.cats.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('depts.create'),
                    'title' => trans('aux.depts.create')
                ],
                [
                    'link'  => route('depts.index'),
                    'title' => trans('aux.depts.index')
                ],
            ]
        ];

        return $links;
    }
}
