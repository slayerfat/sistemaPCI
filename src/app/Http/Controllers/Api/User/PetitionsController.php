<?php

namespace PCI\Http\Controllers\Api\User;

use PCI\Http\Requests;
use PCI\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use Response;

class PetitionsController extends Controller
{

    /**
     * La implementacion de este repositorio.
     *
     * @var \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface
     */
    private $repo;

    /**
     * Genera una nueva instancia de este controlador.
     *
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface $repo
     */
    public function __construct(PetitionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Cambia el estado de algun pedido.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus($id, Request $request)
    {
        $results = $this->repo->changeStatus($id, $request->input('status'));

        return Response::json(['status' => $results]);
    }
}
