<?php namespace PCI\Policies\Item;

use PCI\Models\Item;
use PCI\Models\Petition;
use PCI\Models\User;

/**
 * Class PetitionPolicy
 * @package PCI\Policies
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionPolicy
{

    /**
     * @param \PCI\Models\User $user
     * @param \PCI\Models\Petition $petition
     * @return bool
     */
    public function create(User $user, Petition $petition)
    {
        if (!$petition instanceof Petition) {
            throw new \LogicException;
        }

        return $user->isUser() || $user->isAdmin();
    }

    /**
     * @param \PCI\Models\User $user
     * @param \PCI\Models\Petition $petition
     * @param \PCI\Models\Item $item
     * @param int $amount
     * @return bool
     */
    public function addItem(User $user, Petition $petition, Item $item, $amount)
    {
        if (!$petition) {
            throw new \LogicException;
        }

        if ($user->isUser() || $user->isAdmin()) {
            return $item->stock >= $amount;
        }

        return false;
    }
}
