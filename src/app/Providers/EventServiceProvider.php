<?php namespace PCI\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'PCI\Events\NewUserRegistration'               => [
            'PCI\Listeners\Email\EmailUserConfirmation',
        ],
        'PCI\Events\ConfirmationCodeRequest'           => [
            'PCI\Listeners\Email\EmailUserConfirmation',
        ],
        'PCI\Events\Petition\NewPetitionCreation'      => [
            'PCI\Listeners\Email\EmailPetitionEventToAttendants',
            'PCI\Listeners\Email\EmailPetitionEventToCreator',
        ],
        'PCI\Events\Petition\PetitionApprovalRequest'  => [
            'PCI\Listeners\Email\EmailApprovalRequestToAttendants',
        ],
        'PCI\Events\Petition\PetitionUpdatedByCreator' => [
            'PCI\Listeners\Email\EmailPetitionUpdatedToAttendants',
        ],
        'PCI\Events\Note\NewItemEgress'                => [
            'PCI\Listeners\Note\GenerateItemEgress',
        ],
        'PCI\Events\Note\NewItemIngress'               => [
            'PCI\Listeners\Note\GenerateItemIngress',
            'PCI\Listeners\Email\Note\EmailNewItemMovements',
        ],
        'PCI\Events\Note\NewNoteCreation'              => [
            'PCI\Listeners\Item\RollbackItemReservedAmount',
            'PCI\Listeners\Email\Note\EmailNewNoteToUser',
            'PCI\Listeners\Email\Note\EmailNewNoteToCreator',
        ],
        'PCI\Events\Note\RejectedEgressNote'           => [
            'PCI\Listeners\Item\RollbackItemReservedAmount',
        ],
        'PCI\Events\Petition\UpdateItemReserved'       => [
            'PCI\Listeners\Item\ReserveItemStock',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
        //
    }
}
