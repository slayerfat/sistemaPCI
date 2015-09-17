<?php namespace PCI\Policies;

use PCI\Models\User;

class UserPolicy
{

    /**
     * @param \PCI\Models\User $user
     * @param \PCI\Models\User $resource
     * @return bool
     */
    public function update(User $user, User $resource)
    {
        return $user->isOwnerOrAdmin($resource->id);
    }

    /**
     * @param \PCI\Models\User $user
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->isAdmin();
    }
}
