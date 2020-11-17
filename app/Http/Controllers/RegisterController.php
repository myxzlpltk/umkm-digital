<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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

            $urlAvatar = preg_replace('/s[\d]+/', 's500', $googleUser->avatar);
            $contentAvatar = Http::get($urlAvatar)->body();
            $fileAvatar = $googleUser->getId().'.jpg';
            Storage::put('avatars/'.$fileAvatar, $contentAvatar);

            $user = new User;
            $user->name = $googleUser->getName();
            $user->email = $googleUser->getEmail();
            $user->password = '';
            $user->avatar = $fileAvatar;
            $user->google_name = $googleUser->getName();
            $user->google_email = $googleUser->getEmail();
            $user->google_avatar = $googleUser->getAvatar();
            $user->role = Session::pull('register_role');
            $user->markEmailAsVerified();

            $user->save();

            auth()->login($user);

            return redirect()->route('profile');
        } catch (\Exception $e){
            return redirect()->route('register')->with([
                'wronguserpass' => 'Uppss.. Terjadi kesalahan server. Coba lagi nanti!'
            ]);
        }
    }

}
