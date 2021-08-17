<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function($user){
        
            return $user->is_adm;
        });

        Gate::define('create_clan', function($user){
            return !$user->clan_id;
        });

        Gate::define('validator', function($user){
            return $user->is_validator;
        });

        Gate::define('adm', function($user){
            return $user->is_adm;
        });

        Gate::define('superuser', function($user){
            return $user->is_superuser;
        });

        Gate::define('clan_member', function($user){
            return $user->clan_id;
        });
    }
}
