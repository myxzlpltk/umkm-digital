<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $attributes = [
        'description' => '',
        'discount' => 0,
        'rating' => null,
        'stock' => 0,
    ];

    public function toSearchableArray(){
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'discount' => $this->discount,
            'stock' => $this->stock,
            'rating' => $this->rating,
            'category' => $this->category->name,
            'store_name' => $this->seller->store_name,
            'phone_number' => $this->seller->phone_number,
            'address' => $this->seller->address,
            'image' => asset("storage/products/{$this->image}"),
        ];
    }

    protected function makeAllSearchableUsing($query){
        return $query->with(['category', 'seller']);
    }

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
