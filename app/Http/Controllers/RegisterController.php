<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller{

    public function redirectToProvider(Request $request){
        $request->validate([
            'role' => 'required|in:buyer,seller'
        ]);

        Session::put('register_role', $request->role);

        return Socialite::driver('google')
            ->redirectUrl(route('register.google.callback'))
            ->redirect();
    }

    public function handleProviderCallback(Request $request){
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('register.google.callback'))
                ->user();

            if(User::where('google_email', $googleUser->getEmail())->first()){
                return redirect()->route('register')->with([
                    'error' => 'Akun sudah terdaftar'
                ]);
            }

            $user = new User;
            $user->name = $googleUser->getName();
            $user->email = $googleUser->getEmail();
            $user->password = '';
            $user->google_name = $googleUser->getName();
            $user->google_email = $googleUser->getEmail();
            $user->google_avatar = $googleUser->getAvatar();
            $user->role = Session::pull('register_role');
            $user->markEmailAsVerified();
            $user->save();

            auth()->login($user);

            return redirect('/');
        } catch (\Exception $e){
            return redirect()->route('register')->with([
                'wronguserpass' => 'Uppss.. Terjadi kesalahan server. Coba lagi nanti!'
            ]);
        }
    }

}
