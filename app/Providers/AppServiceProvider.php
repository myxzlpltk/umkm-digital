<?php

namespace App\Providers;

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
        Relation::morphMap([
            'buyer' => 'App\Models\Buyer',
            'seller' => 'App\Models\Seller',
        ]);

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
