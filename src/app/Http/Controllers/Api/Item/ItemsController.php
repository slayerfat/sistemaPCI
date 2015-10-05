<?php namespace PCI\Http\Controllers\Api\Item;

use Input;
use PCI\Http\Controllers\Controller;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;

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
     * Regresa una coleccion con paginador, esta coleccion es
     * buscada por medio del termino que proviene del URL.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexWithTerm()
    {
        $data = Input::only('term');

        return $this->itemRepo->getIndexJsonWithSearch($data);
    }
}
