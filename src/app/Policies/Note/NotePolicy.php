<?php namespace PCI\Policies\Note;

use PCI\Models\Note;
use PCI\Models\User;

/**
 * Class NotePolicy
 *
 * @package PCI\Policies\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NotePolicy
{

    /**
     * Por ahora actualizar no necesita condiciones especiales.
     *
     * @param \PCI\Models\User $user
     * @param \PCI\Models\Note $note
     * @return bool
     */
    public function update(User $user, Note $note)
    {
        return $this->create($user, $note);
    }

    /**
     * @param \PCI\Models\User $user
     * @param \PCI\Models\Note $note
     * @return bool
     */
    public function create(User $user, Note $note)
    {
        if (!$note instanceof Note) {
            throw new \LogicException;
        }

        return $user->isAdmin();
    }
}
