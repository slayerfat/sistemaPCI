<?php

namespace PCI\Events;

use Illuminate\Queue\SerializesModels;
use PCI\Models\User;

class NewUserRegistration extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
