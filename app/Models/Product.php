<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $attributes = [
        'description' => '',
        'discount' => 0,
        'rating' => null,
        'stock' => 0,
    ];

    public function seller(){
        return $this->belongsTo('App\Models\Seller');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function order_details(){
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function carts(){
        return $this->hasMany('App\Models\Cart');
    }

    public function getImageAttribute(){
        return $this->attributes['image'] ?: "default.jpg";
    }

    public function getDiscountPriceAttribute(){
        return round(($this->discount/100)*$this->price);
    }

    public function getPriceAfterDiscountAttribute(){
        return round($this->price-$this->discount_price);
    }
}
