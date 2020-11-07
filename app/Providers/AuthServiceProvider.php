<?php

namespace App\Providers;

use App\Models\Seller;
use App\Models\User;
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

        Gate::define('isAdmin', function (User $user){
            return $user->role === 'admin';
        });

        Gate::define('isBuyer', function (User $user){
            return $user->role === 'buyer';
        });

        Gate::define('isSeller', function (User $user){
            return $user->role === 'seller';
        });

        Gate::define('isBuyerOrSeller', function (User $user){
            return $user->role === 'buyer' || $user->role === 'seller';
        });
    }
}
