<?php namespace PCI\Http\Controllers\User;

use Event;
use Flash;
use Illuminate\View\Factory as View;
use PCI\Events\NewUserRegistration;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\CheckDestroyStatusTrait;
use PCI\Http\Requests;
use PCI\Http\Requests\User\UserRequest;
use PCI\Models\Profile;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use Redirect;

/**
 * Class UsersController
 * @package PCI\Http\Controllers\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UsersController extends Controller
{

    use CheckDestroyStatusTrait;

    /**
     * La implementacion del repositorio de usuario.
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * La fabrica que genera la vista.
     * @var View
     */
    private $view;

    /**
     * Genera una nueva instancia del controlador.
     * Este controlador genera las vistas injectadolas
     * aqui en este constructor.
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface $userRepo
     * @param View $view
     */
    public function __construct(UserRepositoryInterface $userRepo, View $view)
    {
        $this->userRepo = $userRepo;
        $this->view     = $view;

        // el middleware de admin
        $this->middleware('admin', ['except' => ['edit', 'update', 'show']]);
    }

    /**
     * Regresa un listado de recursos.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = $this->userRepo->getIndexViewVariables();
        $users->getModel()->setPath(route('users.index'));

        return $this->view->make('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @param \PCI\Models\Profile $profile la instancia injectada por el IOC de laravel.
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Profile $profile)
    {
        $user = $this->userRepo->newInstance();

        $profiles = $profile->lists('desc', 'id');

        return $this->view->make('users.create', compact('user', 'profiles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \PCI\Http\Requests\User\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepo->create($request->all());

        // cuando un usuario es creado y guardado,
        // se dispara el evento o regla de negocio
        // relacionada con un nuevo usuario en el sistema.
        Event::fire(new NewUserRegistration($user));

        Flash::success(trans('models.users.create.success') . ' Correo electrónico de confirmacion enviado.');

        return Redirect::route('users.show', $user->name);
    }

    /**
     * Display the specified resource.
     * @param  string|int $id El slug|id identificador.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = $this->userRepo->find($id);

        return $this->view->make('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  string|int $id El slug|id identificador.
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        /** @var \PCI\Models\User $user */
        $user = $this->userRepo->find($id);

        if ($user->cannot('update', $user)) {
            return $this->redirectBack();
        }

        //todo: crear repo?
        $profiles = Profile::lists('desc', 'id');

        return $this->view->make('users.edit', compact('user', 'profiles'));
    }

    /**
     * Update the specified resource in storage.
     * @param \PCI\Http\Requests\User\UserRequest $request
     * @param  int $id El id identificador.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepo->update($id, $request->all());

        Flash::success(trans('models.users.udpate.success'));

        return Redirect::route('users.show', $user->name);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id El id identificador.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->checkDestroyStatus($this->userRepo->delete($id), 'users');
    }
}
