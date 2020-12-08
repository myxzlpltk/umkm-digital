<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'dimensions:min_width=200,min_height=200'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validate();

        if(!empty($input['avatar'])){
            $image = Image::make($input['avatar']);
            $dim = min($image->width(), $image->height(), 500);

            $avatar = Str::random(64).'.jpg';
            Storage::disk('public')->put("avatars/$avatar", $image->fit($dim)->encode('jpg', 80));

            $user->avatar = $avatar;
            $user->save();
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->email_verified_at = null;

        $user->sendEmailVerificationNotification();
    }
}
