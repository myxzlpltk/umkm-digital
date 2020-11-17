<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Bank;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;

class ProfileController extends Controller{

    use PasswordValidationRules;

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
                $request->session()->flash('error', 'Akun sudah terdaftar.');

                return redirect()->route('profile');
            }

            $user = $request->user();
            $user->google_name = $googleUser->getName();
            $user->google_email = $googleUser->getEmail();
            $user->google_avatar = $googleUser->getAvatar();
            $user->save();

            $request->session()->flash('success', 'Akun Google telah kaitkan.');

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

        if($request->user()->password == ''){
            $request->session()->flash('error', 'Kamu tidak bisa memutuskan akun Google sebelum menambahkan kata sandi.');
            return redirect()->route('profile');
        }

        $user = $request->user();
        $user->google_name = NULL;
        $user->google_email = NULL;
        $user->google_avatar = NULL;
        $user->save();

        $request->session()->flash('success', 'Akun Google telah diputuskan.');

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

    public function addPassword(Request $request){
        $request->validate([
            'password' => $this->PasswordRules()
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->flash('success', 'Kata sandi telah ditambahkan.');

        return redirect()->route('profile');
    }

    public function updateSeller(Request $request){
        $request->validate([
            'logo' => ['nullable', 'image', 'dimensions:min_width=200,min_height=200'],
            'banner' => ['nullable', 'image', 'dimensions:min_width=200,min_height=200'],
            'store_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|numeric|starts_with:8',
            'bank_id' => 'required|exists:App\Models\Bank,id',
            'account_number' => 'required|numeric',
            'account_name' => 'required|string',
        ]);

        $seller = Seller::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'store_name' => $request->store_name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
            ],
        );

        if($request->file('logo')){
            $image = Image::make($request->file('logo'));
            $dim = min($image->width(), $image->height(), 500);

            $logo = Str::random(64).'.jpg';
            Storage::disk('public')->put("logos/$logo", $image->fit($dim)->encode('jpg', 80));

            $seller->logo = $logo;
            $seller->save();
        }

        if($request->file('banner')){
            $image = Image::make($request->file('banner'));
            $dim = min($image->width(), $image->height(), 600);

            $banner = Str::random(64).'.jpg';
            Storage::disk('public')->put("banners/$banner", $image->fit($dim, $dim/3)->encode('jpg', 80));

            $seller->banner = $banner;
            $seller->save();
        }

        $request->session()->flash('success', 'Data penjual telah diperbarui.');

        return redirect()->route('profile');
    }

    public function updateBuyer(Request $request){
        $request->validate([
            'address' => 'required|string',
            'phone_number' => 'required|numeric|starts_with:8',
            'bank_id' => 'required|exists:App\Models\Bank,id',
            'account_number' => 'required|numeric',
            'account_name' => 'required|string',
        ]);

        Buyer::updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
            ],
        );

        $request->session()->flash('success', 'Data pembeli telah diperbarui.');

        return redirect()->route('profile');
    }
}
