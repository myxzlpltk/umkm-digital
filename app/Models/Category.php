<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function seller(){
        return $this->belongsTo('App\Models\Seller');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
