<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller{

    public function show(User $user){
        if($user->isAdmin) return abort(403);

        return view('users.show', [
            'user' => $user
        ]);
    }
}
