<?php

namespace App\Providers;

use App\Models\Buyer;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Policies\BuyerPolicy;
use App\Policies\CartPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
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
        Buyer::class => BuyerPolicy::class,
        Cart::class => CartPolicy::class,
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Seller::class => SellerPolicy::class,
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
            return $user->isAdmin;
        });

        Gate::define('isBuyer', function (User $user){
            return $user->isBuyer;
        });

        Gate::define('isSeller', function (User $user){
            return $user->isSeller;
        });

        Gate::define('isSellerHasStore', function (User $user){
            return $user->isSeller && $user->seller !== null;
        });

        Gate::define('isAdminOrSeller', function (User $user){
            return $user->isAdmin || $user->isSeller;
        });

        Gate::define('isBuyerOrSeller', function (User $user){
            return $user->isBuyer || $user->isSeller;
        });

        Gate::define('isBuyerOrGuest', function (?User $user){
            return $user === null || $user->isBuyer;
        });
    }
}
