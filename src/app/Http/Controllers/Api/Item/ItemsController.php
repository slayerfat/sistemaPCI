<?php namespace PCI\Http\Controllers\Api\Item;

use Input;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;
use Response;

/**
 * Class ItemsController
 * @package PCI\Http\Controllers\Api\Item
 * Esta mamarrachada esta incompleta. TEP.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemsController extends Controller
{

    /**
     * La implementacion del repositorio de items.
     * @var \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface
     */
    private $itemRepo;

    /**
     * Necesitamos instanciar la interface por medio del service provider.
     * @param \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface $itemRepo
     */
    public function __construct(ItemRepositoryInterface $itemRepo)
    {
        $this->itemRepo = $itemRepo;
    }

    /**
     * Regresa los items del sistema.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return $this->itemRepo->newInstance()->paginate(10);
    }

    /**
     * Regresa una coleccion con paginador, esta coleccion es
     * buscada por medio del termino que proviene del URL.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexWithTerm()
    {
        $data = Input::only('term');

        return $this->itemRepo->getIndexJsonWithSearch($data);
    }

    /**
     * Regresa el stock en formato legible de algun item.
     * @param string|int $id el id o slug del item
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStock($id)
    {
        return Response::json($this->itemRepo->getStock($id));
    }
}
