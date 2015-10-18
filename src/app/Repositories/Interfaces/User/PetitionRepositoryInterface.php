<?php

/**
 * Por ahora esta interface solo sirve como amalgama de las distintas
 * interfaces que el repositorio utliza.
 * Se hizo de esta forma porque cuando se solicita la implementacion
 * de un repositorio se debe dar el que corresponde, es
 * decir, si algun solicita la interfaz de arepas,
 * hay que darle la implementacion de arepas.
 * Pudiera ser mejorado.
 *
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link   https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */

namespace PCI\Repositories\Interfaces\User;

use Illuminate\Support\Collection;
use PCI\Repositories\Interfaces\ModelRepositoryInterface;
use PCI\Repositories\Interfaces\RepositoryPaginatorInterface;
use PCI\Repositories\Interfaces\Viewable\GetIndexViewableInterface;

interface PetitionRepositoryInterface extends
    ModelRepositoryInterface,
    RepositoryPaginatorInterface,
    GetIndexViewableInterface
{

    /**
     * Cambia el estado del pedido.
     *
     * @param int  $id
     * @param bool $status
     * @return bool
     */
    public function changeStatus($id, $status);

    /**
     * Genera una coleccion de items relacionados
     * con el pedido en formato para HTML.
     *
     * @param \Illuminate\Support\Collection $items
     * @return \Illuminate\Support\Collection
     */
    public function getItemsCollection(Collection $items);

    /**
     * Busca las peticiones segun el Id de algun usuario.
     *
     * @param string|int $id del usuario.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByUserId($id);

    /**
     * Regresa una coleccion de pedidos sin notas asociadas.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findWithoutNotes();
}
