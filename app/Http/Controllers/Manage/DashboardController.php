<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller{

    public function index(){
        if(Gate::allows('isAdmin')){
            return view('manage.admin');
        }
        elseif(Gate::allows('isSeller')){
            return view('manage.seller', [
                'seller' => auth()->user()->seller,
            ]);
        }

        return abort(404);
    }
}
