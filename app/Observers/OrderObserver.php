<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Track;
use App\Notifications\UpdateStatusOrder;
use Illuminate\Support\Facades\Storage;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order){
        $track = new Track;
        $track->order_id = $order->id;
        $track->status_code = $order->status_code;
        $track->save();

        foreach($order->details as $detail){
            $detail->product->stock = $detail->product->stock - $detail->qty;
            $detail->save();
        }

        $order->buyer->user->notify(new UpdateStatusOrder($order));
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if($order->wasChanged('status_code')){
            $track = new Track;
            $track->order_id = $order->id;
            $track->status_code = $order->status_code;
            $track->save();

            $order->buyer->user->notify(new UpdateStatusOrder($order));
        }

        if($order->wasChanged('payment_proof')){
            $oldImage = $order->getOriginal('payment_proof');
            if(!empty($oldImage) && Storage::exists("payments/$oldImage")){
                Storage::delete("payments/$oldImage");
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
