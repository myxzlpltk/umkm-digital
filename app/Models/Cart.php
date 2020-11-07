<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function buyer(){
        return $this->belongsTo('App\Models\Buyer');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
