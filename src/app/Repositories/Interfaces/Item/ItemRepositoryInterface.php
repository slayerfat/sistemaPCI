<?php

/**
 * Por ahora esta interface solo sirve como amalgama de las distintas
 * interfaces que el repositorio utliza.
 * Se hizo de esta forma porque cuando se solicita la implementacion
 * de un repositorio se debe dar el que corresponde, es
 * decir, si algun solicita la interfaz de arepas,
 * hay que darle la implementacion de arepas.
 * Pudiera ser mejorado.
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */

namespace PCI\Repositories\Interfaces\Item;

use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\RepositoryPaginatorInterface;
use PCI\Repositories\Interfaces\Viewable\GetIndexViewableInterface;

interface ItemRepositoryInterface extends
    ModelRepositoryInterface,
    RepositoryPaginatorInterface,
    GetIndexViewableInterface
{

    /**
     * Devuelve un array asociativo con
     * las categorias y subcategorias.
     * @return array|array[]
     */
    public function getSubCatsLists();

    /**
     * Busca items en la base de datos segun la
     * data proveniente y regresa un paginador.
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getIndexJsonWithSearch(array $data);
}
