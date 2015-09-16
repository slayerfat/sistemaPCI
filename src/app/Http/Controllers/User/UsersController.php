<?php namespace PCI\Http\Controllers\User;

use View;
use Redirect;
use PCI\Http\Requests;
use PCI\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use PCI\Http\Requests\UserRequest;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\UserRepositoryInterface;

class UsersController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * @param UserRepositoryInterface $userRepo
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(UserRepositoryInterface $userRepo, Factory $view)
    {
        $this->userRepo = $userRepo;
        $this->view     = $view;

        $this->middleware('admin', ['except' => 'edit', 'update', 'show']);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = $this->userRepo->getAll();

        return View::make('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = $this->userRepo->getNewInstance();

        $profiles = Profile::lists('desc', 'id');

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

        return View::make('users.show', compact('user'));
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

        $profiles = Profile::lists('desc', 'id');

        return View::make('users.edit', compact('user', 'profiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepo->find($id);

        $user->fill($request->all());

        return $user;
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
