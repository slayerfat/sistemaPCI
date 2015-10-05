<?php namespace PCI\Policies\Item;

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
}
