<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);


        if($validated['current_password'] === $validated['password']) {
            $notification = [
                'message' => 'New password cannot be the same as the current password',
                'type' => 'error'
            ];

            return back()->with($notification);
        }


        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $notification = [
            'message' => 'Password updated successfully',
            'type' => 'success'
        ];

        return back()->with($notification);
    }
}
