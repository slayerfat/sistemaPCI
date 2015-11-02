<?php namespace PCI\Http\Controllers\Api\User;

use Auth;
use Event;
use Illuminate\Http\Request;
use PCI\Events\Petition\PetitionApprovalRequest;
use PCI\Events\Petition\UpdateItemReserved;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\Api\HasDefaultJsonMsg;
use PCI\Http\Controllers\Traits\RespondsToChangeStatus;
use PCI\Http\Requests;
use PCI\Models\Petition;
use PCI\Repositories\Interfaces\Aux\PetitionTypeRepositoryInterface;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use Response;

/**
 * Class PetitionsController
 *
 * @package PCI\Http\Controllers\Api\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionsController extends Controller
{

    use HasDefaultJsonMsg;

    /**
     * Esto es para la re-implementacion del trait.
     *
     * @see      cara 'e papeo.
     * @link     https://pbs.twimg.com/media/AtT11CoCIAArVcY.jpg
     */
    use RespondsToChangeStatus {
        changeStatus as changePrototype;
    }

    /**
     * La implementacion de este repositorio.
     *
     * @var \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Repositories\Aux\PetitionTypeRepository
     */
    private $petitionTypeRepo;

    /**
     * Genera una nueva instancia de este controlador.
     *
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface    $repo
     * @param \PCI\Repositories\Interfaces\Aux\PetitionTypeRepositoryInterface $petitionTypeRepo
     */
    public function __construct(
        PetitionRepositoryInterface $repo,
        PetitionTypeRepositoryInterface $petitionTypeRepo
    ) {
        $this->repo             = $repo;
        $this->petitionTypeRepo = $petitionTypeRepo;
    }

    /**
     * cambia el status de la nota y genera un movimiento.
     *
     * @param string|int               $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus($id, Request $request)
    {
        /** @var Petition $petition */
        $petition = $this->repo->find($id);

        if (!is_null($petition->status)) {
            return Response::json([
                'status'  => false,
                'message' => 'El estatus del Pedido no puede ser alterado, ',
            ]);
        }

        $response = self::changePrototype($id, $request);

        $this->fireEvent($petition);

        return $response;
    }

    private function fireEvent(Petition $petition)
    {
        if ($petition->isMovementTypeOut()) {
            Event::fire(new UpdateItemReserved($petition));
        }
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
     * Busca y devuelve la informacion necesaria para saber si el tipo de
     * movimiento relacionado con algun pedido es entrada o salida.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function movementType(Request $request)
    {
        if (!$request->has('id')) {
            return $this->jsonMsg();
        }

        /** @var \PCI\Models\PetitionType $type */
        $type = $this->petitionTypeRepo->find($request->input('id'));

        return Response::json([
            'status'  => true,
            'model'   => $type,
            'ingress' => $type->movementType->isIn(),
        ]);
    }
}
