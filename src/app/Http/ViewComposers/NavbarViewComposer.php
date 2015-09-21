<?php namespace PCI\Http\ViewComposers;

use PCI\Models\User;
use Illuminate\View\View;
use Illuminate\Auth\Guard;
use Bootstrapper\Navigation;
use PCI\Mamarrachismo\Bootstrapper\IconPCI;

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
        $this->icon = new IconPCI;
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
                    'title' => $this->icon->create('sign-in') . 'Entrar'
                ],
                [
                    'link'  => route('auth.getRegister'),
                    'title' => $this->icon->create('check-square-o') . 'Registrarse'
                ],
            ];
        }

        return [
            [
                "Hola " . $this->user->name,
                [
                    [
                        'link'  => route('users.show', $this->user->name),
                        'title' => $this->icon->create('eye') . trans('models.users.show')
                    ],
                    [
                        'link'  => route('auth.getLogout'),
                        'title' => $this->icon->create('sign-out') . 'Salir'
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
                'title' => $this->icon->create(trans('models.petitions.fa-icon'))
                    . trans('models.petitions.plural')
            ],
            [
                'link'  => '#',
                'title' => $this->icon->create(trans('models.notes.fa-icon'))
                    . trans('models.notes.plural')
            ],
            [
                $this->icon->create('archive') . 'Items',
                [
                    [
                        'link'  => '#',
                        'title' => $this->icon->create('plus-circle') . 'Crear'
                    ],
                    [
                        'link'  => '#',
                        'title' => $this->icon->create('eye') . 'Consultar'
                    ],
                    Navigation::NAVIGATION_DIVIDER,
                    [
                        'link'  => '#',
                        'title' => $this->icon->create('plus') . '...'
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
            $this->icon->create('wrench') . 'Mant.',
            [
                [
                    'link'  => route('users.index'),
                    'title' => $this->icon->create(trans('models.users.fa-icon'))
                        . trans('models.users.index')
                ],
                [
                    'link'  => '#',
                    'title' => $this->icon->create(trans('models.profiles.fa-icon'))
                        . trans('models.profiles.index')
                ],
                [
                    'link'  => route('genders.index'),
                    'title' => $this->icon->create(trans('models.genders.fa-icon'))
                        . trans('models.genders.index')
                ],
                [
                    'link'  => route('depts.index'),
                    'title' => $this->icon->create(trans('models.depts.fa-icon'))
                        . trans('models.depts.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('cats.index'),
                    'title' => $this->icon->create(trans('models.cats.fa-icon'))
                        . trans('models.cats.index')
                ],
                [
                    'link'  => '#',
                    'title' => $this->icon->create(trans('models.subCats.fa-icon'))
                        . trans('models.subCats.index')
                ],
                [
                    'link'  => route('itemTypes.index'),
                    'title' => $this->icon->create(trans('models.itemTypes.fa-icon'))
                        . trans('models.itemTypes.index')
                ],
                Navigation::NAVIGATION_DIVIDER,
                [
                    'link'  => route('makers.index'),
                    'title' => $this->icon->create(trans('models.makers.fa-icon'))
                        . trans('models.makers.index')
                ],
                [
                    'link'  => route('movementTypes.index'),
                    'title' => $this->icon->create(trans('models.movementTypes.fa-icon'))
                        . trans('models.movementTypes.index')
                ],
            ]
        ];

        return $links;
    }
}
