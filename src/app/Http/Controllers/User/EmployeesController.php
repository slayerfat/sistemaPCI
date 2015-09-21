<?php

namespace PCI\Http\Controllers\User;

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
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        return View::make('employees.create', compact('user', 'employee'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
