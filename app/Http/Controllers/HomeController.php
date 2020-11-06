<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class HomeController extends Controller{

    public function welcome(){
        $sellers = Seller::limit(12)->get();

        return view('welcome', [
            'sellers' => $sellers
        ]);
    }
}
