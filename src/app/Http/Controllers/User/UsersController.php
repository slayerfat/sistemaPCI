<?php namespace PCI\Http\Controllers\User;

use Flash;
use Redirect;
use PCI\Http\Requests;
use PCI\Models\Profile;
use PCI\Http\Requests\UserRequest;
use PCI\Http\Controllers\Controller;
use Illuminate\View\Factory as View;
use PCI\Repositories\Interfaces\UserRepositoryInterface;

class UsersController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @var View
     */
    private $view;

    /**
     * @param UserRepositoryInterface $userRepo
     * @param View                    $view
     */
    public function __construct(UserRepositoryInterface $userRepo, View $view)
    {
        $this->userRepo = $userRepo;
        $this->view     = $view;

        $this->middleware('admin', ['except' => ['edit', 'update', 'show']]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = $this->userRepo->getAll();

        return $this->view->make('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @param \PCI\Models\Profile $profile
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Profile $profile)
    {
        $user = $this->userRepo->getNewInstance();

        $profiles = $profile->lists('desc', 'id');

        return $this->view->make('users.create', compact('user', 'profiles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \PCI\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        return $request->all();

        // Redirect::route('users.show', $user->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $user = $this->userRepo->find($id);

        return $this->view->make('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id);

        if ($user->cannot('update', $user)) {
            return $this->redirectBack();
        }

        $profiles = Profile::lists('desc', 'id');

        return $this->view->make('users.edit', compact('user', 'profiles'));
    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param             $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepo->update($id, $request->all());

        Flash::success('Usuario actualizado correctamente.');

        return Redirect::route('users.show', $user->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
    }
}
