<?php namespace PCI\Listeners\Email;

use PCI\Models\Attendant;
use PCI\Models\Depot;
use PCI\Models\User;

/**
 * Class AbstractItemEmail
 *
 * @package PCI\Listeners\Email
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractItemEmail extends AbstractEmailListener
{

    /**
     * Busca los jefes de almacen de los almacenes.
     *
     * @return void
     */
    protected function findDepotOwnersEmail()
    {
        $owners = $this->findDepotOwners();

        foreach ($owners as $owner) {
            $this->toCc->push($owner->email);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function findDepotOwners()
    {
        $ids    = Depot::groupBy('user_id')->lists('user_id')->toArray();
        $owners = User::find($ids);

        return $owners;
    }

    /**
     * Busca los correos de los encargados de almacen en el sistema.
     *
     * @return array
     */
    protected function getAttendantsEmail()
    {
        Attendant::all()->load('user')->each(function (Attendant $attendant) {
            $push = false;

            foreach ($this->toCc as $email) {
                if ($attendant->user->email == $email) {
                    $push = true;
                    break;
                }
            }

            $push ?: $this->emails->push($attendant->user->email);
        });
    }
}
