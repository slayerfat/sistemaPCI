<?php

namespace PCI\Http\Controllers\User;

use Event;
use Flash;
use Gate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\Factory as View;
use PCI\Events\Petition\NewPetitionCreation;
use PCI\Events\Petition\PetitionUpdatedByCreator;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\CheckDestroyStatusTrait;
use PCI\Http\Requests;
use PCI\Http\Requests\User\PetitionRequest;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use Redirect;

class PetitionsController extends Controller
{

    use CheckDestroyStatusTrait;

    /**
     * La implementacion del repositorio de pedidos.
     *
     * @var \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface
     */
    private $repo;

    /**
     * La factoria de las vistas.
     *
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * Genera la instancia de este controlador.
     *
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface $repo
     * @param \Illuminate\View\Factory                                      $view
     */
    public function __construct(PetitionRepositoryInterface $repo, View $view)
    {

        $this->repo = $repo;
        $this->view = $view;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petitions = $this->repo->getIndexViewVariables();

        return $this->view->make('petitions.index', compact('petitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $petition = $this->repo->newInstance();
        $types    = $this->repo->typeList();

        return $this->view->make('petitions.create', compact('petition', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \PCI\Http\Requests\User\PetitionRequest $request
     * @param \Illuminate\Contracts\Auth\Guard        $auth
     * @return \Illuminate\Http\Response
     */
    public function store(PetitionRequest $request, Guard $auth)
    {
        /** @var \PCI\Models\Petition $petition */
        $petition = $this->repo->create($request->all());

        /** @var \PCI\Models\User $user */
        $user = $auth->user();

        Event::fire(new NewPetitionCreation($petition, $user));

        Flash::success(trans('models.petitions.store.success'));

        return Redirect::route('petitions.show', $petition->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $petition = $this->repo->find($id);

        return $this->view->make('petitions.show', compact('petition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $petition = $this->repo->find($id);

        if (Gate::denies('update', $petition)) {
            return $this->redirectBack(
                'Los '
                . trans('models.petitions.plural')
                . ' solo pueden ser editados si están por aprobar.'
            );
        }

        $types = $this->repo->typeList();

        return $this->view->make('petitions.edit', compact('petition', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \PCI\Http\Requests\User\PetitionRequest $request
     * @param  int                                    $id
     * @return \Illuminate\Http\Response
     */
    public function update(PetitionRequest $request, $id)
    {
        /** @var \PCI\Models\Petition $petition */
        $petition = $this->repo->update($id, $request->all());

        /** @var \PCI\Models\User $user */
        $user = auth()->user();

        Event::fire(new PetitionUpdatedByCreator($petition, $user));

        Flash::success(trans('models.petitions.update.success'));

        return Redirect::route('petitions.show', $petition->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petition = trans('models.petitions.singular');
        $items    = trans('models.items.plural');
        $mvt      = trans('models.movements.plural');

        return $this->checkDestroyStatus(
            $this->repo->delete($id),
            'petitions',
            "Para eliminar un $petition este no debe "
            . "estar asociado a otros $items y/o $mvt, "
            . "además, este NO debe estar en algún "
            . "estado de Aprobado o No Aprobado."
        );
    }
}
