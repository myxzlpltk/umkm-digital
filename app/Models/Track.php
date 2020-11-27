<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model{

    use HasFactory;

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function getStatusAttribute(){
        return key_exists($this->status_code, Order::status)
            ? __(Order::status[$this->status_code])
            : __('Tidak Diketahui');
    }
}
