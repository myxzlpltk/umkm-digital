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
        return $this->morphOne('App\Models\User', 'role', 'id');
    }

    public function days(){
        return $this->belongsToMany('App\Models\Day')
            ->using('App\Models\DaySeller')
            ->withPivot(['start', 'end'])
            ->withTimestamps();
    }
}
