<?php namespace PCI\Http\ViewComposers;

use Illuminate\Auth\Guard;
use Illuminate\View\View;
use PCI\Mamarrachismo\Bootstrapper\IconPCI;

/**
 * Class NavbarViewComposer
 * @package PCI\Http\ViewComposers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NavbarViewComposer
{

    /**
     * El usuario actualmente en el sistema.
     * @var \PCI\Models\User
     */
    private $user;

    /**
     * El IconPCI que genera los iconos para las vistas.
     * @var \PCI\Mamarrachismo\Bootstrapper\IconPCI
     */
    private $icon;

    /**
     * Genera una nueva instancia de este composer
     * con la implementacion de Guard.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
        $this->icon = new IconPCI;
    }

    /**
     * Genera las variables necesarias para
     * la vista, en este caso el navbar.
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
        $searchBox = $this->getSearchBox();

        // regresa la vista con las variables generadas.
        $view->with(compact('links', 'rightLinks', 'searchBox'));
    }

    /**
     * Genera el array necesario para mostrar  los enlaces
     * en el navbar excepto el lado derecho.
     * Al igual que self::getRightLinks, genera
     * un array asociativo con links y titulo.
     * @return array un array de arrays asociativos con link y titulo.
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
                    'divider',
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
     * Genera los enlaces de mantenimiento que solo
     * deberian ser vistos por el administrador.
     * @param array $links los enlaces previamente hechos para ser fusionados.
     * @return array un array de arrays asociativos con link y titulo.
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
                    'link'  => route('profiles.index'),
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
                [
                    'link'  => route('nats.index'),
                    'title' => $this->icon->create(trans('models.nats.fa-icon'))
                        . trans('models.nats.index')
                ],
                'divider',
                [
                    'link'  => route('cats.index'),
                    'title' => $this->icon->create(trans('models.cats.fa-icon'))
                        . trans('models.cats.index')
                ],
                [
                    'link'  => route('subCats.index'),
                    'title' => $this->icon->create(trans('models.subCats.fa-icon'))
                        . trans('models.subCats.index')
                ],
                [
                    'link'  => route('itemTypes.index'),
                    'title' => $this->icon->create(trans('models.itemTypes.fa-icon'))
                        . trans('models.itemTypes.index')
                ],
                'divider',
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
                [
                    'link'  => route('noteTypes.index'),
                    'title' => $this->icon->create(trans('models.noteTypes.fa-icon'))
                        . trans('models.noteTypes.index')
                ],
                [
                    'link'  => route('petitionTypes.index'),
                    'title' => $this->icon->create(trans('models.petitionTypes.fa-icon'))
                        . trans('models.petitionTypes.index')
                ],
            ]
        ];

        return $links;
    }

    /**
     * Genera el array necesario para mostrar  los enlaces
     * en el navbar del lado derecho.
     * Este array esta compuesto de arrays
     * asociativos con el link y titulo.
     * @return array un array de arrays asociativos con link y titulo.
     */
    private function getRightLinks()
    {
        // si el usuario no existe, entonces es un guest
        // asi que se le invita a entrar o registrarse.
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

        // de lo contrario se crean los links necesarios
        // para que el usuario pueda manipular su cuenta.
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
     * Regresa el formulario necesario para el navbar.
     * @return string
     */
    private function getSearchBox()
    {
        return '<form class="navbar-form navbar-left hidden-sm" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Indique su busqueda">
                    </div>
                    <button type="submit" class="btn btn-default">Buscar</button>
                </form>';
    }
}
