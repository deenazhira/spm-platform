<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',                  // Minimum 8 characters
                'regex:/[a-z]/',          // At least one lowercase letter
                'regex:/[A-Z]/',          // At least one uppercase letter
                'regex:/[0-9]/',          // At least one digit
                'regex:/[@$!%*#?&]/',     // At least one special character
                'confirmed',              // Must match password_confirmation
            ],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $salt = Str::random(8); // ✅ generate salt

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'salt' => $salt, // ✅ store salt
            'password' => Hash::make($input['password'] . $salt), // ✅ hash with salt
        ]);
    }
}
