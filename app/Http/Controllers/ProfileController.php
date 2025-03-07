<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $authUser = Auth::user();
        $userdetails = UserDetails::where('user_id', $authUser->id)->first();
        $userTenant = Tenant::where('id', $userdetails->tenant_id)->first();
        return view('profile.edit', [
            'user' => $request->user(),
            'authUser' => $authUser,
            'userTenant' => $userTenant,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) { 
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();

            $notification = [
                'message' => $firstError,
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $userDetail = UserDetails::where('user_id', $user_id)->first();
        $userDetail->gender = $request->gender;
        $userDetail->phone_number = $request->phone_number;
        $userDetail->psn = $request->psn;
        $userDetail->grade_level = $request->grade_level;
        $userDetail->rank = $request->rank;
        $userDetail->schedule = $request->schedule;
        $userDetail->employment_date = $request->employment_date;
        $userDetail->date_of_birth = $request->date_of_birth;


        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');
            $name = Str::of($user->name)->replace(' ', '')->toString();
            $filename = $name . '_' . time() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/avatars');

            $file->move($destinationPath, $filename);

            if (!empty($userDetail->avatar) && file_exists(public_path($userDetail->avatar))) {
                unlink(public_path($userDetail->avatar));
            }
            $userDetail->avatar =  $filename;
        }

        $userDetail->save();

        $notification = [
            'message' => 'Profile updated sucessfully',
            'alert-type' => 'success',
        ];

        return Redirect::route('profile.edit')->with($notification);
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
