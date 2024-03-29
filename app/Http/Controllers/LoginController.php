<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller{

    public function redirectToProvider(Request $request){
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request){
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_email', $googleUser->getEmail())->first();
            if($user){
                auth()->login($user);

                return redirect('/');
            }
            else{
                return redirect()->route('login')->with([
                    'error' => 'Akun tidak ditemukan.'
                ]);
            }
        } catch (\Exception $e){
            return redirect()->route('login')->with([
                'error' => 'Uppss.. Terjadi kesalahan server. Coba lagi nanti!'
            ]);
        }
    }

    public function redirectToHome(Request $request){
        if(Gate::allows('isAdmin')){
            return redirect()->route('manage');
        }
        elseif(Gate::allows('isSeller')){
            if(auth()->user()->seller){
                return redirect()->route('manage');
            }
            else{
                return redirect()->route('profile');
            }
        }
        elseif(Gate::allows('isBuyer')){
            return redirect()->route('home');
        }
        else{
            auth()->logout();

            return redirect()->route('login');
        }
    }

}
