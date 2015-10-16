<?php namespace PCI\Http\Controllers\Api\Item;

use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Repositories\Interfaces\Aux\StockTypeRepositoryInterface;
use Response;

/**
 * Class StockTypesController
 * @package PCI\Http\Controllers\Api\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class StockTypesController extends Controller
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\StockTypeRepositoryInterface
     */
    private $repo;

    /**
     * @param \PCI\Repositories\Interfaces\Aux\StockTypeRepositoryInterface $repo
     */
    public function __construct(StockTypeRepositoryInterface $repo)
    {

        $this->repo = $repo;
    }

    public function index()
    {
        $types = $this->repo->getAll();

        return Response::json($types);
    }
}
