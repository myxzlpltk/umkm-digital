<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller{

    public function welcome(){
        if(Gate::denies('isBuyerOrGuest')){
            return redirect()->route('login.redirect');
        };

        $sellers = Seller::limit(12)->get();

        return view('welcome', [
            'sellers' => $sellers
        ]);
    }
}
