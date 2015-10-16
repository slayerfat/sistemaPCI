<?php namespace PCI\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\Petition;
use PCI\Models\User;
use PCI\Models\WorkDetail;
use PCI\Policies\Item\PetitionPolicy;
use PCI\Policies\User\AddressPolicy;
use PCI\Policies\User\EmployeePolicy;
use PCI\Policies\User\UserPolicy;
use PCI\Policies\User\WorkDetailPolicy;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [
        User::class       => UserPolicy::class,
        Employee::class   => EmployeePolicy::class,
        Address::class    => AddressPolicy::class,
        WorkDetail::class => WorkDetailPolicy::class,
        Petition::class   => PetitionPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
    }
}
