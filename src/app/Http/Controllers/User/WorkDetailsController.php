<?php namespace PCI\Http\Controllers\User;

use Illuminate\Http\Request;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface;

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
     * Genera una instancia de este controlador.
     * @param \PCI\Repositories\Interfaces\User\WorkDetailRepositoryInterface $repo
     */
    public function __construct(WorkDetailRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
