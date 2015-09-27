<?php namespace PCI\Http\Controllers\Item;

use Illuminate\View\Factory as View;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\CheckDestroyStatusTrait;
use PCI\Http\Requests;
use PCI\Http\Requests\DepotRequest;
use PCI\Repositories\Interfaces\Item\DepotRepositoryInterface;
use Redirect;

/**
 * Class DepotsController
 * @package PCI\Http\Controllers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotsController extends Controller
{

    use CheckDestroyStatusTrait;

    /**
     * La fabrica que genera las vistas.
     * @var \Illuminate\View\Factory
     */
    private $view;

    /**
     * La implementacion del repositorio de almacenes.
     * @var \PCI\Repositories\Interfaces\Item\DepotRepositoryInterface
     */
    private $repo;

    /**
     * Genera una nueva instancia de este controlador.
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Item\DepotRepositoryInterface $repo
     */
    public function __construct(View $view, DepotRepositoryInterface $repo)
    {
        $this->view = $view;
        $this->repo = $repo;

        $this->middleware('admin', ['except' => 'index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depots = $this->repo->getIndexViewVariables();

        return $this->view->make('depots.index', compact('depots'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depot = $this->repo->newInstance();

        return $this->view->make('depot.create', compact('depot'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \PCI\Http\Requests\DepotRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepotRequest $request)
    {
        $depot = $this->repo->create($request->all());

        return Redirect::route('depots.show', $depot->id);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $depot = $this->repo->find($id);

        return $this->view->make('depots.show', compact('depot'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depot = $this->repo->find($id);

        return $this->view->make('depots.edit', compact('depot'));
    }

    /**
     * Update the specified resource in storage.
     * @param \PCI\Http\Requests\DepotRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepotRequest $request, $id)
    {
        $depot = $this->repo->update($id, $request->all());

        return Redirect::route('depots.show', $depot->id);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->checkDestroyStatus($this->repo->delete($id), 'depots');
    }
}
