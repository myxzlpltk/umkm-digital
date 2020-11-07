<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller{

    public function profile(Request $request){
        return view('profile.view', [
            'user' => Auth::user(),
            'banks' => Bank::all(),
        ]);
    }
}
