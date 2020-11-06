<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{

    public function sellers(){
        return $this->belongsToMany('App\Models\Seller')
            ->using('App\Models\DaySeller')
            ->withPivot(['start', 'end'])
            ->withTimestamps();
    }
}
