<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function buyer(){
        return $this->belongsTo('App\Models\Buyer');
    }

    public function details(){
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function getStatusAttribute(){
        $status = [
            1 => 'Payment Pending',
            2 => 'Payment In Process',
            3 => 'Order Being Processed',
            4 => 'In Delivery',
            5 => 'Order Completed',
            6 => 'Canceled',
            7 => 'Refund Being Processed',
            8 => 'Refund Completed',
        ];

        return key_exists($this->status_code, $status)
            ? __('Unknown.')
            : __($status[$this->status_code]);
    }
}
