<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get user profile information
     */
    public function show()
    {
        try {
            $user = Auth::user();
            $userDetails = $user->userDetail;
            
            return response()->json([
                'user' => $user,
                'user_details' => $userDetails,
                'tenant' => $userDetails ? $userDetails->tenant : null,
                'department' => $userDetails ? $userDetails->tenant_department : null
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch profile'], 500);
        }
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone_number' => 'nullable|string|max:20',
                'designation' => 'nullable|string|max:255',
                'avatar' => 'nullable|string',
                'signature' => 'nullable|string',
                'nin_number' => 'nullable|string|max:20',
                'gender' => 'nullable|in:male,female,other'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Update user basic info
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update user details if they exist
            if ($user->userDetail) {
                $user->userDetail->update([
                    'phone_number' => $request->phone_number,
                    'designation' => $request->designation,
                    'avatar' => $request->avatar,
                    'signature' => $request->signature,
                    'nin_number' => $request->nin_number,
                    'gender' => $request->gender,
                ]);
            }

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user->fresh(),
                'user_details' => $user->userDetail
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update profile'], 500);
        }
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = Auth::user();

            // Check if current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'Current password is incorrect'], 422);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to change password'], 500);
        }
    }

    /**
     * Upload profile avatar
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = Auth::user();
            
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('avatars', $filename, 'public');
                
                // Update user details with avatar path
                if ($user->userDetail) {
                    $user->userDetail->update(['avatar' => $path]);
                }
                
                return response()->json([
                    'message' => 'Avatar uploaded successfully',
                    'avatar_path' => $path
                ], 200);
            }

            return response()->json(['error' => 'No file uploaded'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to upload avatar'], 500);
        }
    }
}