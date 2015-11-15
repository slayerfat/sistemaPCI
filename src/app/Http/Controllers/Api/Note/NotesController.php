<?php namespace PCI\Http\Controllers\Api\Note;

use Event;
use Illuminate\Http\Request;
use PCI\Events\Note\NewItemEgress;
use PCI\Events\Note\NewItemIngress;
use PCI\Events\Note\RejectedEgressNote;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\Api\HasDefaultJsonMsg;
use PCI\Http\Controllers\Traits\RespondsToChangeStatus;
use PCI\Http\Requests;
use PCI\Mamarrachismo\Collection\ItemCollection;
use PCI\Models\Note;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use Response;

/**
 * Class NotesController
 *
 * @package PCI\Http\Controllers\Api\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NotesController extends Controller
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
     * @var \PCI\Repositories\Interfaces\Note\NoteRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface
     */
    private $noteTypeRepo;

    /**
     * Genera una nueva instancia de este api.
     *
     * @param NoteRepositoryInterface     $repo
     * @param NoteTypeRepositoryInterface $noteTypeRepo
     */
    public function __construct(
        NoteRepositoryInterface $repo,
        NoteTypeRepositoryInterface $noteTypeRepo
    ) {
        $this->repo         = $repo;
        $this->noteTypeRepo = $noteTypeRepo;
    }

    /**
     * Genera un nuevo PDF relacionada con la nota.
     * TODO: implementar
     *
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeNewPdf($id)
    {
        return Response::json(['status' => $id]);
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
        /** @var Note $note */
        $note = $this->repo->find($id);

        if (!is_null($note->status)) {
            return $this->jsonMsg(false, 'El estatus de la Nota no puede ser alterado, '
                . 'porque la misma ha generado un movimiento.');
        }

        // si se pretende aprobar la nota, debemos chequear que
        // haya la data para asociar los items con los almacenes.
        $newStatus = $this->parseStatus($request->input('status'));
        if ($newStatus && !$request->has('data')) {
            return $this->jsonMsg(false, 'El estatus de la Nota no puede ser alterado, '
                . 'No hay {data:data}.');
        }

        // el cambio de status genera de una vez la respuesta JSON
        $response = self::changePrototype($id, $request);

        // debe ser FALSO porque nulo es por aprobar
        if ($newStatus === false) {
            return Event::fire(new RejectedEgressNote($note));
        }

        // se dispara el evento apropiado
        $data = $this->makeDataArray($request->input('data'));
        try {
            $this->fireEvent($note, $data);
        } catch (\Exception $e) {
            $this->changeToNull($id);
            $class = class_basename($e);
            $msg   = str_limit($e->getMessage(), 40);

            return $this->jsonMsg(false, "Error fatal: [$class], $msg");
        }

        return $response;
    }

    /**
     * @param array $data
     * @return ItemCollection
     */
    private function makeDataArray(array $data)
    {
        $results = new ItemCollection;

        foreach ($data as $array) {
            $results
                ->setItemId($array['item_id'])
                ->setDepotId($array['depot_id'])
                ->setDue($array['due'])
                ->setAmount($array['amount'])
                ->setStockTypeId($array['stock_type_id'])
                ->make();
        }

        return $results;
    }

    /**
     * Dispara el evento correspondiente para los movimientos de
     * la nota segun su tipo (entrada/salida).
     *
     * @param \PCI\Models\Note $note
     * @param ItemCollection   $data
     * @return array|null
     */
    private function fireEvent(Note $note, ItemCollection $data)
    {
        if ($note->isMovementTypeIn()) {
            return Event::fire(new NewItemIngress($note, $data));
        }

        return Event::fire(new NewItemEgress($note));
    }

    /**
     * Busca y devuelve la informacion necesaria para saber si el tipo de
     * movimiento relacionado con alguna nota es entrada o salida.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function movementType(Request $request)
    {
        if (!$request->has('id')) {
            return $this->jsonMsg(false);
        }

        /** @var \PCI\Models\NoteType $type */
        $type = $this->noteTypeRepo->find($request->input('id'));

        return Response::json([
            'status'  => true,
            'model'   => $type,
            'ingress' => $type->movementType->isIn(),
        ]);
    }
}
