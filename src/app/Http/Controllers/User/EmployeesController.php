<?php

namespace PCI\Http\Controllers\User;

use Flash;
use Illuminate\Auth\Guard;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Http\Requests\User\CreateEmployeeRequest;
use PCI\Http\Requests\User\UpdateEmployeeRequest;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;
use Redirect;
use View;

class EmployeesController extends Controller
{

    /**
     * @var \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface
     */
    private $empRepo;

    /**
     * @var \PCI\Models\User
     */
    private $currentUser;

    /**
     * @param \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface $empRepo
     * @param \Illuminate\Auth\Guard $auth
     */
    public function __construct(EmployeeRepositoryInterface $empRepo, Guard $auth)
    {
        $this->empRepo = $empRepo;

        $this->currentUser = $auth->user();
    }

    /**
     * Show the form for creating a new resource.
     * @param string|int $id
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $user = $this->empRepo->findUser($id);
        $employee = $this->empRepo->newInstance();

        // necesitamos saber si el usuario puede o no editar este recurso.
        if ($this->currentUser->cant('create', [$employee, $user])) {
            return $this->redirectBack();
        }

        //TODO abstraer esto a un repo
        $genders = Gender::lists('desc', 'id');
        $nats    = Nationality::lists('desc', 'id');

        return View::make('employees.create', compact('user', 'employee', 'genders', 'nats'));
    }

    /**
     * Store a newly created resource in storage.
     * @param string|int $id
     * @param \PCI\Http\Requests\User\CreateEmployeeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, CreateEmployeeRequest $request)
    {
        $data = $request->all();

        // solucion mamarracha, pero asi nos
        // ahorramos modificar la interface
        $data['user_id'] = $id;

        $user = $this->empRepo->create($data);

        Flash::success(trans('models.employees.store.success'));

        return Redirect::route('users.show', $user->name);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->empRepo->find($id);

        // necesitamos saber si el usuario puede o no editar este recurso.
        if ($this->currentUser->cant('update', $employee)) {
            return $this->redirectBack();
        }

        $genders = Gender::lists('desc', 'id');
        $nats    = Nationality::lists('desc', 'id');

        return View::make('employees.edit', compact('employee', 'genders', 'nats'));
    }

    /**
     * Update the specified resource in storage.
     * @param \PCI\Http\Requests\User\UpdateEmployeeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $user = $this->empRepo->update($id, $request->all());

        Flash::success(trans('models.employees.update.success'));

        return Redirect::route('users.show', $user->name);
    }
}
