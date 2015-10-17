<?php

namespace PCI\Http\Controllers\Note;

use Illuminate\Http\Request;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Models\NoteType;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use View;

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
     * @param \PCI\Repositories\Interfaces\Note\NoteRepositoryInterface     $repo
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface $petitionRepo
     */
    public function __construct(
        NoteRepositoryInterface $repo,
        PetitionRepositoryInterface $petitionRepo
    ) {
        $this->repo         = $repo;
        $this->petitionRepo = $petitionRepo;
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

        // TODO: repo
        $types = NoteType::lists('desc', 'id');

        $petitions = $this->petitionRepo->findWithoutNotes();

        $list = [];

        $petitions->each(function ($petition) use (&$list) {
            $list[$petition->id] = "#$petition->id"
            . ", "
            . "Items: "
            . $petition->itemCount . ", "
            . "Solicitado por: " . $petition->user->name
            . ", " . $petition->user->email;
        });

        return View::make('notes.create', compact('note', 'types', 'petitions', 'list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
