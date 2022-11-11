<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
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
        User::class => UserPolicy::class,
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
        Passport::cookie('you_shall_not_pass');

        Gate::before(function ($user, $ability) {
            return $user->hasRole('superAdmin') ? true : true;
        });

        Gate::define('isAdmin',function($user){
            return $user->tipo === 'admin';
        });

        Gate::define('isDefault',function($user){
            return $user->tipo === 'default';
        });


        Gate::define('isGerente',function($user){
            return $user->tipo === 'gerente';
        });

        Gate::define('isAdminOrGerente',function($user){
            return ($user->tipo === 'gerente' || $user->tipo === 'admin'  );
        });


        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        //
    }
}
