<?php

namespace App\Observers;

use App\Models\Seller;
use Illuminate\Support\Facades\Storage;

class SellerObserver
{
    /**
     * Handle the Seller "created" event.
     *
     * @param  \App\Models\Seller  $seller
     * @return void
     */
    public function created(Seller $seller)
    {
        //
    }

    /**
     * Handle the Seller "updated" event.
     *
     * @param  \App\Models\Seller  $seller
     * @return void
     */
    public function updated(Seller $seller){
        if($seller->wasChanged('logo')){
            $oldLogo = $seller->getOriginal('logo');
            if($oldLogo != 'default.jpg' && Storage::exists("logos/$oldLogo")){
                Storage::delete("logos/$oldLogo");
            }
        }

        if($seller->wasChanged('banner')){
            $oldBanner = $seller->getOriginal('banner');
            if($oldBanner != 'default.jpg' && Storage::exists("banners/$oldBanner")){
                Storage::delete("banners/$oldBanner");
            }
        }
    }

    /**
     * Handle the Seller "deleted" event.
     *
     * @param  \App\Models\Seller  $seller
     * @return void
     */
    public function deleted(Seller $seller)
    {
        //
    }

    /**
     * Handle the Seller "restored" event.
     *
     * @param  \App\Models\Seller  $seller
     * @return void
     */
    public function restored(Seller $seller)
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     *
     * @param  \App\Models\Seller  $seller
     * @return void
     */
    public function forceDeleted(Seller $seller)
    {
        //
    }
}
