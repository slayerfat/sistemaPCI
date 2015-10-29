<?php namespace PCI\Http\Controllers\Api\Note;

use Event;
use Illuminate\Http\Request;
use PCI\Events\Note\NewItemEgress;
use PCI\Events\Note\NewItemIngress;
use PCI\Http\Controllers\Controller;
use PCI\Http\Controllers\Traits\RespondsToChangeStatus;
use PCI\Http\Requests;
use PCI\Models\Note;
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
     * Genera una nueva instancia de este api.
     *
     * @param NoteRepositoryInterface $repo
     */
    public function __construct(NoteRepositoryInterface $repo)
    {
        $this->repo = $repo;
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
            return Response::json([
                'status'  => false,
                'message' => 'El estatus de la Nota no puede ser alterado, '
                    . 'porque la misma ha generado un movimiento.',
            ]);
        }

        $response = self::changePrototype($id, $request);
        $data = $this->makeDataArray($request->input('data'));

        $this->fireEvent($note, $data);

        return $response;
    }

    /**
     * @param array $data
     * @return array
     */
    private function makeDataArray(array $data)
    {
        $results = [];
        foreach ($data as $array) {
            $results[$array['item']] = ['depot_id' => $array['depot']];
        }

        return $results;
    }

    /**
     * Dispara el evento correspondiente para los movimientos de
     * la nota segun su tipo (entrada/salida).
     *
     * @param \PCI\Models\Note $note
     * @param array            $data
     * @return array|null
     */
    private function fireEvent(Note $note, array $data)
    {
        if ($note->isMovementTypeIn()) {
            return Event::fire(new NewItemIngress($note, $data));
        }

        return Event::fire(new NewItemEgress($note));
    }
}
