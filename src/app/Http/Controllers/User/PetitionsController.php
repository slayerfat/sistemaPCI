<?php

namespace PCI\Http\Controllers\User;

use Event;
use Flash;
use Illuminate\View\Factory as View;
use PCI\Events\NewPetitionCreation;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Http\Requests\User\PetitionRequest;
use PCI\Models\PetitionType;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use Redirect;

class PetitionsController extends Controller
{

    /**
     * La implementacion del repositorio de pedidos.
     * @var \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface
     */
    private $repo;

    /**
     * La factoria de las vistas.
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * Genera la instancia de este controlador.
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface $repo
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(PetitionRepositoryInterface $repo, View $view)
    {

        $this->repo = $repo;
        $this->view = $view;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petitions = $this->repo->getIndexViewVariables();

        return $this->view->make('petitions.index', compact('petitions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $petition = $this->repo->newInstance();

        // todo: segun perfil, usuario no hace entrada
        $types = PetitionType::lists('desc', 'id');

        return $this->view->make('petitions.create', compact('petition', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \PCI\Http\Requests\User\PetitionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PetitionRequest $request)
    {
        /** @var \PCI\Models\Petition $petition */
        $petition = $this->repo->create($request->all());

        Event::fire(new NewPetitionCreation($petition));

        Flash::success("Petición #$petition->id creada exitosamente.");

        return Redirect::route('petitions.show', $petition->id);
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
     * @param \PCI\Http\Requests\User\PetitionRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PetitionRequest $request, $id)
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
