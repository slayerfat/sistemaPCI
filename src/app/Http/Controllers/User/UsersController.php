<?php namespace PCI\Http\Controllers\User;

use Illuminate\Http\Request;

use PCI\Models\Profile;
use View;
use PCI\Http\Requests;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\UserRepositoryInterface;

class UsersController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
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

        return View::make('users.create', compact('user', 'profiles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $request->all();
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
     * @return Response
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
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
