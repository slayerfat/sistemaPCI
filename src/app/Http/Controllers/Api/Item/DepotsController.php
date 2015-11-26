<?php namespace PCI\Http\Controllers\Api\Item;

use App;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Repositories\Interfaces\Item\DepotRepositoryInterface;

/**
 * Class DepotsController
 *
 * @package PCI\Http\Controllers
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotsController extends Controller
{

    /**
     * @var \PCI\Repositories\Interfaces\Item\DepotRepositoryInterface
     */
    private $repo;

    /**
     * @param DepotRepositoryInterface $repo
     */
    public function __construct(DepotRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Genera un nuevo PDF relacionado con el almacen.
     *
     * @param string|int $id
     * @return \Illuminate\Http\Response
     */
    public function singlePdf($id)
    {
        $depot = $this->repo->find($id);
        $pdf   = App::make('dompdf.wrapper');
        $title = "/ Reporte de " . trans('models.depots.singular');

        $pdf->loadView('depots.pdf.single', compact('depot', 'title'));

        return $pdf->stream();
    }
}
