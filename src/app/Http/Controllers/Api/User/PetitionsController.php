<?php namespace PCI\Http\Controllers\Api\User;

use Auth;
use Event;
use Illuminate\Http\Request;
use PCI\Events\Petition\PetitionApprovalRequest;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\RespondsToChangeStatus;
use PCI\Http\Requests;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use Response;

class PetitionsController extends Controller
{

    use RespondsToChangeStatus;

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
            return $this->jsonMsg();
        }

        $petition = $this->repo->find($request->input('id'));

        $items = $this->repo->getItemsCollection($petition->items);

        return Response::json($items->toArray());
    }

    /**
     * @param string $str
     * @return \Illuminate\Http\JsonResponse
     */
    private function jsonMsg($str = 'Id necesario para continuar.')
    {
        return Response::json(['status' => $str]);
    }

    public function movementType(request $request)
    {
        if (!$request->has('id')) {
            return $this->jsonMsg();
        }

        /** @var \PCI\Models\Petition $petition */
        $petition = $this->repo->find($request->input('id'));

        return Response::json([
            'status'  => true,
            'model'   => $petition,
            'ingress' => $petition->type->movementType()->first()->isIn(),
        ]);
    }
}
