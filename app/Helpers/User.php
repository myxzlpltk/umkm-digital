<?php

namespace App\Helpers;

use Carbon\Carbon;

class User{

    public static function greeting(){
        $x = Carbon::now()->hour;

        if($x <= 4 || $x >= 18){
            return 'Selamat Malam!';
        }
        elseif($x <= 10){
            return 'Selamat Pagi!';
        }
        elseif($x <= 14){
            return 'Selamat Siang!';
        }
        else{
            return 'Selamat Sore!';
        }
    }

    public static function idr($money){
        return "Rp. ".str_replace(',','.',number_format($money));
    }

}
