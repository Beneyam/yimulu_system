<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        
        Gate::define('manage-users',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','agent-manager']);
        });
        Gate::define('manage-agents',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','agent-manager','staff-agent']);
        });
        Gate::define('edit-users',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','agent-manager']);
        });
        Gate::define('manage-vc',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','vc-manager']);
        });
        Gate::define('manage-report',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','reporter']);
        });
        Gate::define('manage-system',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasRole('admin');
        });
        Gate::define('manage-terminal',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','staff-agent']);
           // return $user->hasRole('admin');
        });
        Gate::define('manage-others',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','staff-agent','agent-manager','transaction-manager']);
           // return $user->hasRole('admin');
        });
        Gate::define('verify-deposits',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','finance']);
           // return $user->hasRole('admin');
        });
        Gate::define('manage-transaction',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','transaction-manager']);
        });
        Gate::define('fill-balance',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['admin','staff-agent']);
        });
        Gate::define('staff-view',function($user){
            //dd($user->hasRole('Agent Manager'));
            return $user->hasAnyRoles(['staff-agent']);
        });
        //
    }
}
