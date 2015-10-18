<?php namespace PCI\Http\Controllers\Note;

use Event;
use Flash;
use Gate;
use Illuminate\Support\Collection;
use PCI\Events\Note\NewNoteCreation;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests\Note\NoteRequest;
use PCI\Models\NoteType;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use Redirect;
use View;

/**
 * Class NotesController
 *
 * @package PCI\Http\Controllers\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NotesController extends Controller
{

    /**
     * La implementacion del repo de Notas.
     *
     * @var \PCI\Repositories\Note\NoteRepository
     */
    private $repo;

    /**
     * La implementacion del repo de Pedidos.
     *
     * @var \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface
     */
    private $petitionRepo;

    /**
     * La implementacion del repo de usuarios.
     *
     * @var \PCI\Repositories\Interfaces\User\UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Genera una instancia de este controlador.
     *
     * @param \PCI\Repositories\Interfaces\Note\NoteRepositoryInterface     $repo
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface $petitionRepo
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface     $userRepo
     */
    public function __construct(
        NoteRepositoryInterface $repo,
        PetitionRepositoryInterface $petitionRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->repo         = $repo;
        $this->petitionRepo = $petitionRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = $this->repo->getIndexViewVariables();

        return View::make('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $note = $this->repo->newInstance();

        if (Gate::denies('create', [$note, $this->petitionRepo])) {
            return $this->redirectBack(
                "No existen "
                . trans('models.petitions.plural')
                . " aprobados que necesiten alguna "
                . trans('models.notes.singular')
                . " en el sistema."
            );
        }

        // TODO: repo
        $types = NoteType::lists('desc', 'id');
        $petitions = $this->petitionRepo->findWithoutNotes();
        $list  = $this->makePetitionsList($petitions);
        $users = $this->makeUsersList();

        return View::make(
            'notes.create',
            compact('note', 'types', 'petitions', 'list', 'users')
        );
    }

    /**
     * @param \Illuminate\Support\Collection $petitions
     * @return array
     */
    private function makePetitionsList(Collection $petitions)
    {
        $list = [];

        $petitions->each(function ($petition) use (&$list) {
            $list[$petition->id] = "#$petition->id"
                . ", "
                . "Items: "
                . $petition->itemCount . ", "
                . "Solicitado por: " . $petition->user->name
                . ", " . $petition->user->email;
        });

        return $list;
    }

    /**
     * Regresa un arreglo de usuarios con seudonimo y correo.
     *
     * @return array
     */
    private function makeUsersList()
    {
        $list = [];

        $users = $this->userRepo->usersList();

        $users->each(function ($user) use (&$list) {
            $list[$user->id] = $user->name
                . ", " . $user->email;
        });

        return $list;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \PCI\Http\Requests\Note\NoteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {
        /** @var \PCI\Models\Note $note */
        $note = $this->repo->create($request->all());

        Event::fire(new NewNoteCreation($note));

        Flash::success(trans('models.notes.store.success'));

        return Redirect::route('notes.show', $note->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \PCI\Http\Requests\Note\NoteRequest $request
     * @param  int                                $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoteRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
