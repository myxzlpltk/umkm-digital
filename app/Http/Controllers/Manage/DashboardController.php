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
            return Response::view('manage.admin');
        }
        elseif(Gate::allows('isSeller')){
            return Response::view('manage.seller', [
                'seller' => Auth::user()->seller,
            ]);
        }

        return abort(404);
    }
}
