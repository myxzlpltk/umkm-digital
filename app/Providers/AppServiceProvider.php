<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        Relation::morphMap([
            'buyer' => 'App\Models\Buyer',
            'seller' => 'App\Models\Seller',
        ]);

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
