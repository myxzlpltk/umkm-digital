<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BuyersController extends Controller{

    public function list(Request $request){
        $buyers = User::with('buyer')
            ->where('role', 'buyer')
            ->get();

        return view('admin.buyers.list', [
            'buyers' => $buyers
        ]);
    }
}
