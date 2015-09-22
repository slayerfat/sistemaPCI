<?php

namespace PCI\Http\Controllers\User;

use PCI\Http\Requests\User\CreateEmployeeRequest;
use PCI\Models\Gender;
use PCI\Models\Nationality;
use View;
use Illuminate\Http\Request;
use PCI\Http\Requests;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface;

class EmployeesController extends Controller
{

    /**
     * @var \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface
     */
    private $empRepo;

    /**
     * @param \PCI\Repositories\Interfaces\User\EmployeeRepositoryInterface $empRepo
     */
    public function __construct(EmployeeRepositoryInterface $empRepo)
    {
        $this->empRepo = $empRepo;
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

        //TODO abstraer esto a un repo
        $genders = Gender::lists('desc', 'id');
        $nats    = Nationality::lists('desc', 'id');

        return View::make('employees.create', compact('user', 'employee', 'genders', 'nats'));
    }

    /**
     * Store a newly created resource in storage.
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

        return View::make('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
