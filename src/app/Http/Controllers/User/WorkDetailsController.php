<?php namespace PCI\Http\Controllers\User;

use Flash;
use Illuminate\View\Factory as View;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Http\Requests\User\WorkDetailRequest;
use PCI\Models\Department;
use PCI\Models\Position;
use PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface;
use Redirect;

/**
 * Class WorkDetailsController
 * @package PCI\Http\Controllers\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class WorkDetailsController extends Controller
{

    /**
     * La implementacion del repositorio de datos laborales.
     * @var \PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface
     */
    private $repo;

    /**
     * La fabrica de vistas.
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * El usuario actualmente en el sistema.
     * @var \PCI\Models\User
     */
    private $user;

    /**
     * Genera una instancia de este controlador.
     * @param \PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface $repo
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(WorkDetailRepositoryInterface $repo, View $view)
    {
        $this->repo = $repo;
        $this->view = $view;
        $this->user = auth()->user();
    }

    /**
     * Show the form for creating a new resource.
     * @param string|int $id el identificador del empleado.
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $employee   = $this->repo->findParent($id);
        $workDetail = $this->repo->newInstance();

        // necesitamos saber si el usuario puede o no editar este recurso.
        if ($this->user->cant('create', [$workDetail, $employee])) {
            return $this->redirectBack();
        }

        // TODO: repo.
        $departments = Department::lists('desc', 'id');
        $positions   = Position::lists('desc', 'id');

        return $this->view
            ->make('employees.workDetails.create')
            ->with(compact('employee', 'workDetail', 'departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param string|int $id El identificador del empleado.
     * @param \PCI\Http\Requests\User\WorkDetailRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, WorkDetailRequest $request)
    {
        $data = $request->all();

        // solucion mamarracha, pero asi nos
        // ahorramos modificar la interface
        $data['user_id'] = $id;

        $user = $this->repo->create($data);

        Flash::success(trans('models.workDetails.store.success'));

        return $this->view->make('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workDetail = $this->repo->find($id);

        // necesitamos saber si el usuario puede o no editar este recurso.
        if ($this->user->cant('update', $workDetail)) {
            return $this->redirectBack();
        }

        // TODO: repo.
        $departments = Department::lists('desc', 'id');
        $positions   = Position::lists('desc', 'id');

        return $this->view->make('employees.edit', compact('workDetail', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     * @param \PCI\Http\Requests\User\WorkDetailRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkDetailRequest $request, $id)
    {
        $user = $this->repo->update($id, $request->all());

        Flash::success(trans('models.employees.update.success'));

        return Redirect::route('users.show', $user->name);
    }
}
