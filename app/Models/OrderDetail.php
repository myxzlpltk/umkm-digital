<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function getDiscountPriceAttribute(){
        return round(($this->discount/100)*$this->price);
    }

    public function getPriceAfterDiscountAttribute(){
        return round($this->price-$this->discount_price);
    }

    public function getSubtotalAttribute(){
        return $this->price_after_discount * $this->qty;
    }
}
