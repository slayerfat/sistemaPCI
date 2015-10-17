<?php namespace PCI\Http\Controllers\Api\User;

use Auth;
use Event;
use Illuminate\Http\Request;
use PCI\Events\Petition\PetitionApprovalRequest;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
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
        if (!$request->exists('status')) {
            return Response::json(['status' => false]);
        }

        $results = $this->repo->changeStatus($id, $request->input('status'));

        return Response::json(['status' => $results]);
    }

    /**
     * Dispara un evento de aprobacion de pedido.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approvalRequest($id)
    {
        /** @var \PCI\Models\Petition $petition */
        $petition = $this->repo->find($id);

        /** @var \PCI\Models\User $user */
        $user = Auth::user();

        Event::fire(new PetitionApprovalRequest($petition, $user));

        return Response::json(['status' => true]);
    }

    /**
     * Devuelve una coleccion de items asociados al pedido.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param int|string $id el identificador del pedido.
     */
    public function items(Request $request)
    {
        if (!$request->has('id')) {
            return Response::json(['status' => 'Id necesario para continuar.']);
        }

        $petition = $this->repo->find($request->input('id'));

        $items = $this->repo->getItemsCollection($petition->items);

        return Response::json($items->toArray());
    }
}
