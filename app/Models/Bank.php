<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{

    public function buyers(){
        return $this->hasMany('App\Models\Buyer');
    }

    public function sellers(){
        return $this->hasMany('App\Models\Seller');
    }
}
