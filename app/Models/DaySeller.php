<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DaySeller extends Pivot
{

    public function day(){
        return $this->belongsTo('App\Models\Day');
    }

    public function seller(){
        return $this->belongsTo('App\Models\Seller');
    }
}
