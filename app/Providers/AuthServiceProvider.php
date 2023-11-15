<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Address;
use App\Models\Client;
use App\Models\Project;
use App\Policies\AddressPolicy;
use App\Policies\ClientPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Client::class => ClientPolicy::class,
        Address::class => AddressPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
