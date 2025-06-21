<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    // Update Profile Information
    public function updateProfileInformation(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('photo')) {
            $user->updateProfilePhoto($request->file('photo'));
        }

        $user->update($validatedData);

        return back()->with('status', 'profile-information-updated');
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => [__('The provided password does not match your current password.')],
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    // Enable Two-Factor Authentication
    public function enableTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();

        $user->forceFill([
            'two_factor_secret' => encrypt($user->createTwoFactorAuthenticationSecret()),
            'two_factor_recovery_codes' => encrypt(json_encode($user->generateTwoFactorRecoveryCodes())),
        ])->save();

        return back()->with('status', 'two-factor-authentication-enabled');
    }

    // Disable Two-Factor Authentication
    public function disableTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        return back()->with('status', 'two-factor-authentication-disabled');
    }

    // Confirm Two-Factor Authentication
    public function confirmTwoFactorAuthentication(Request $request)
    {
        $user = $request->user();

        if (! $user->confirmTwoFactorAuthentication($request->code)) {
            throw ValidationException::withMessages([
                'code' => __('The provided two-factor authentication code was invalid.'),
            ]);
        }

        return back()->with('status', 'two-factor-authentication-confirmed');
    }

    // Log Out Other Browser Sessions
    public function logoutOtherBrowserSessions(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('The provided password does not match your current password.')],
            ]);
        }

        Auth::logoutOtherDevices($request->password);

        return back()->with('status', 'other-browser-sessions-logged-out');
    }

    // Delete User Account
    public function deleteUser(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('The provided password does not match your current password.')],
            ]);
        }

        $user = $request->user();

        Auth::logout();

        $user->delete();

        return redirect('/')->with('status', 'account-deleted');
    }
}
