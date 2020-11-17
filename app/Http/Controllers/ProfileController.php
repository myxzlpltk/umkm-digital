<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class ProfileController extends Controller{

    public function profile(Request $request){
        return view('profile.view', [
            'user' => $request->user(),
            'banks' => Bank::all(),
        ]);
    }

    public function redirectToProvider(Request $request){
        if($request->user()->google_email){
            return abort(403);
        }

        return Socialite::driver('google')
            ->redirectUrl(route('profile.google.callback'))
            ->redirect();
    }

    public function handleProviderCallback(Request $request){
        if($request->user()->google_email){
            return abort(403);
        }

        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('profile.google.callback'))
                ->user();

            if(User::where('google_email', $googleUser->getEmail())->first()){
                $request->session()->flash('error', 'Akun sudah terdaftar');

                return redirect()->route('profile');
            }

            $user = $request->user();
            $user->google_name = $googleUser->getName();
            $user->google_email = $googleUser->getEmail();
            $user->google_avatar = $googleUser->getAvatar();
            $user->save();

            $request->session()->flash('success', 'Akun Google telah kaitkan');

            return redirect()->route('profile');
        } catch (\Exception $e){
            $request->session()->flash('error', 'Uppss.. Terjadi kesalahan server. Coba lagi nanti!');

            return redirect()->route('profile');
        }
    }

    public function disconnectProvider(Request $request){
        if($request->user()->google_email == NULL){
            return abort(403);
        }

        $user = $request->user();
        $user->google_name = NULL;
        $user->google_email = NULL;
        $user->google_avatar = NULL;
        $user->save();

        $request->session()->flash('success', 'Akun Google telah diputuskan');

        return redirect()->route('profile');
    }

    public function showAvatar(Request $request){
        $user = $request->user();
        if($user->google_avatar){
            $contentAvatar = Http::get($user->google_avatar)->body();

            return Response($contentAvatar)->header('Content-Type', 'image/jpg');
        }
        else{
            return abort(404);
        }
    }
}
