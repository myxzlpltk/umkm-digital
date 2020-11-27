<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    public function bank(){
        return $this->belongsTo('App\Models\Bank');
    }

    public function user(){
        return $this->morphOne('App\Models\User',__FUNCTION__, 'role', 'id', 'user_id');
    }

    public function days(){
        return $this->belongsToMany('App\Models\Day')
            ->using('App\Models\DaySeller')
            ->withPivot(['start', 'end'])
            ->withTimestamps();
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function categories(){
        return $this->hasMany('App\Models\Category');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
