<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'account_number',
        'address',
        'bank_id',
        'phone_number',
        'store_name',
        'user_id',
    ];

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
}
