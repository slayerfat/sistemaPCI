<?php namespace PCI\Http\ViewComposers;

use Icon;
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
                    'title' => Icon::create('sign-in') . 'Entrar'
                ],
                [
                    'link'  => route('auth.getRegister'),
                    'title' => Icon::create('check-square-o') . 'Registrarse'
                ],
            ];
        }

        return [
            [
                "Hola " . $this->user->name,
                [
                    [
                        'link'  => route('users.show', $this->user->name),
                        'title' => Icon::create('eye') . trans('models.users.show')
                    ],
                    [
                        'link'  => route('auth.getLogout'),
                        'title' => Icon::create('sign-out') . 'Salir'
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
                'title' => Icon::create('check') . 'Pedidos'
            ],
            [
                'link'  => '#',
                'title' => Icon::create('pencil-square-o') . 'Notas'
            ],
            [
                Icon::create('archive') . 'Items',
                [
                    [
                        'link'  => '#',
                        'title' => Icon::create('plus-circle') . 'Crear'
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
            Icon::create('wrench') . 'Mant.',
            [
                [
                    'link'  => route('users.create'),
                    'title' => Icon::create('plus-circle') . trans('models.users.create')
                ],
                [
                    'link'  => route('users.index'),
                    'title' => Icon::create('users') . trans('models.users.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => '#',
                    'title' => Icon::create('plus-circle') . trans('aux.profiles.create')
                ],
                [
                    'link'  => '#',
                    'title' => Icon::create('user-md') . trans('aux.profiles.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('cats.create'),
                    'title' => Icon::create('plus-circle') . trans('aux.cats.create')
                ],
                [
                    'link'  => route('cats.index'),
                    'title' => Icon::create('th-large') . trans('aux.cats.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => '#',
                    'title' => Icon::create('plus-circle') . trans('aux.subCats.create')
                ],
                [
                    'link'  => '#',
                    'title' => Icon::create('th') . trans('aux.subCats.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('genders.create'),
                    'title' => Icon::create('plus-circle') . trans('aux.genders.create')
                ],
                [
                    'link'  => route('genders.index'),
                    'title' => Icon::create('venus-mars') . trans('aux.genders.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('depts.create'),
                    'title' => Icon::create('plus-circle') . trans('aux.depts.create')
                ],
                [
                    'link'  => route('depts.index'),
                    'title' => Icon::create('puzzle-piece') . trans('aux.depts.index')
                ],

                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => '#',
                    'title' => Icon::create('list') . 'Ver todo'
                ],
            ]
        ];

        return $links;
    }
}
