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
     * Los enlaces en el navbar que contiene funcionalidad comun
     * para todos los usuarios independientemente del perfil.
     * @var array
     */
    private $basicLinks = ['petitions'];

    /**
     * Los enlaces en navbar que contienen funcionalidad
     * completa solo para el administrador del sistema,
     * el resto de los usuarios lo veran incompleto.
     * @var array
     */
    private $augmentedLinks = ['notes', 'items', 'depots'];

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
        // si no hay usuario no se devuelven enlaces,
        // es decir, no veran enlaces.
        if (is_null($this->user)) {
            return [];
        }

        // estos son los enlaces que contienen todas las caracteristicas
        // disponibles y que todos los usuarios pueden manipular.
        $links = $this->makeBasicLinks();

        // estos son los enlaces que solo los administradores tienen
        // acceso completo, los usuarios tienen acceso limitado.
        $links = $this->makeAugmentedLinks($links);

        // enlaces de mantenimiento (administrador)
        if ($this->isUserAdmin()) {
            return $this->makeAdminLinks($links);
        }

        return $links;
    }

    /**
     * Genera los links que todos los perfiles del
     * sistema pueden manipular a plenitud, es
     * decir, pueden crear, consultar, etc.
     * @return array[]
     */
    private function makeBasicLinks()
    {
        $links = [];

        // por cada link normal no interesa un
        // dropdown con acciones basicas.
        foreach ($this->basicLinks as $resource) {
            $links[] = $this->dropdownLinks($resource);
        }

        return $links;
    }

    /**
     * ESte arreglo genera todos los enlaces disponibles por
     * cada recurso, lo hace en forma de dropdown.
     * @param string $resource El recurso ej: 'users' o 'items'.
     * @return array<string, array>
     */
    private function dropdownLinks($resource)
    {
        return [
            $this->icon->create(trans("models.{$resource}.fa-icon"))
            . trans("models.{$resource}.plural"),
            [
                $this->innerArrayCreate($resource),
                $this->innerArrayIndex($resource),
                'divider',
                $this->innerArrayTodo($resource),
            ]
        ];
    }

    /**
     * Genera un enlace que apunta a crear un nuevo recurso.
     * Genera un array con informacion valida para los enlaces de tipo
     * dropdown generados por esta clase, es decir el genera el
     * array interno que necesita el array padre.
     * @param string $resource El recurso ej: 'users' o 'items'.
     * @param string $icon El icono por defecto de este enlace.
     * @return array<string, string>
     */
    private function innerArrayCreate($resource, $icon = 'plus-circle')
    {
        return [
            'link'  => $this->getRoute("{$resource}.create"),
            'title' => $this->icon->create($icon) . 'Crear'
        ];
    }

    /**
     * Genera un enlace de placeholder.
     * Genera un array con informacion valida para los enlaces de tipo
     * dropdown generados por esta clase, es decir el genera el
     * array interno que necesita el array padre.
     * Regresa el enlace generado por route().
     * Si falla atrapa la excepcion.
     * @param string $route la direccion: 'users.index'
     * @return string
     */
    private function getRoute($route)
    {
        try {
            return route($route);
        } catch (\InvalidArgumentException $e) {
            return "#{$route}.failed";
        }
    }

    /**
     * Genera un enlace que apunta a el listado general de un recurso.
     * Genera un array con informacion valida para los enlaces de tipo
     * dropdown generados por esta clase, es decir el genera el
     * array interno que necesita el array padre.
     * @param string $resource El recurso ej: 'users' o 'items'.
     * @param string $icon El icono por defecto de este enlace.
     * @return array<string, string>
     */
    private function innerArrayIndex($resource, $icon = 'eye')
    {
        return [
            'link'  => $this->getRoute("{$resource}.index"),
            'title' => $this->icon->create($icon) . 'Consultar'
        ];
    }

    /**
     * @param string $resource El recurso ej: 'users' o 'items'.
     * @return array<string, string>
     */
    private function innerArrayTodo($resource)
    {
        return [
            'link'  => '#',
            'title' => $this->icon->create('plus') . "... {$resource}"
        ];
    }

    /**
     * Solo los administradores tienen acceso a todas las
     * caracteristicas de estos enlaces, el resto de
     * los usuarios lo tienen de forma limitada.
     * @param array $links los links son array de arrays
     * @return array
     */
    private function makeAugmentedLinks($links)
    {
        // como debemos generar los links pero chequeando el
        // perfil del usuario, entonces por cada enlace
        // ejecutamos el metodo checkUserProfile
        foreach ($this->augmentedLinks as $resource) {
            $links[] = $this->checkUserProfile($resource);
        }

        return $links;
    }

    /**
     * Genera los links segun el perfil del usuario.
     * @param string $resource El recurso ej: 'users' o 'items'.
     * @return array
     */
    private function checkUserProfile($resource)
    {
        // si el usuario es administrador se generan
        // todos los links normales en un dropdown.
        if ($this->isUserAdmin()) {
            return $this->dropdownLinks($resource);
        }

        // de lo contrario se le muestra un link normal.
        return $this->plainLink($resource);
    }

    /**
     * Chequea si el usuario es administrador.
     * @return bool
     */
    private function isUserAdmin()
    {
        return $this->user && $this->user->isAdmin();
    }

    /**
     * Genera un array que simboliza enlaces basicos en el navbar,
     * estos apuntan al index del recurso ej: 'users.index'
     * @param string $resource El recurso ej: 'users' o 'items'.
     * @return array<string, string>
     */
    private function plainLink($resource)
    {
        return [
            'link'  => $this->getRoute("{$resource}.index"),
            'title' => $this->icon->create(trans("models.{$resource}.fa-icon"))
                . trans("models.{$resource}.index")
        ];
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
                $this->plainLink('users'),
                $this->plainLink('profiles'),
                $this->plainLink('genders'),
                $this->plainLink('nats'),
                'divider',
                $this->plainLink('depts'),
                $this->plainLink('positions'),
                'divider',
                $this->plainLink('cats'),
                $this->plainLink('subCats'),
                $this->plainLink('itemTypes'),
                $this->plainLink('stockTypes'),
                'divider',
                $this->plainLink('makers'),
                $this->plainLink('movementTypes'),
                $this->plainLink('noteTypes'),
                $this->plainLink('petitionTypes'),
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
     * @return string el string con informacion HTML.
     */
    private function getSearchBox()
    {
        // si el usuario no tiene sesion no
        // muestra la barra de busqueda.
        if (is_null($this->user)) {
            return '';
        }

        return '<form class="navbar-form navbar-left hidden-sm" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Indique su busqueda">
                    </div>
                    <button type="submit" class="btn btn-default">Buscar</button>
                </form>';
    }
}
