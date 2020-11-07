<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SellersController extends Controller{

    public function list(Request $request){
        $sellers = User::with('seller')
            ->where('role', 'seller')
            ->get();

        return view('admin.sellers.list', [
            'sellers' => $sellers
        ]);
    }
}
