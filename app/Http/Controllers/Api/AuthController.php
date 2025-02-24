<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => 'required',
            'nin_number' => 'required|digits:11',
            'gender' => 'required|in:male,female',
            'account_type' => 'required|in:individual,corporate',
            'company_name' => 'required_if:account_type,corporate|max:255',
            'rc_number' => 'required_if:account_type,corporate|max:255',
            'company_address' => 'required_if:account_type,corporate|max:255',
            // 'g-recaptcha-response' => 'recaptcha',
            'region' => 'required|in:nigeria,international',
            'state' => 'nullable|required_if:region,nigeria',
            'lga' => 'nullable|required_if:region,nigeria',
            'country' => 'nullable|required_if:region,international|max:255',
            'default_role' => 'required|string', // Ensure default_role is provided
        ]);
    
        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }
    
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'default_role' => $request->default_role,
        ]);
    
        // Create user details
        $corporate_user = "Corporate User";
        $userDetailsData = [
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'nin_number' => $request->nin_number ?? null,
            'designation' => $request->account_type === 'corporate' ? $corporate_user : $request->designation,
            'tenant_id' => 1, // Default tenant ID
            'gender' => $request->gender,
            'account_type' => $request->account_type,
            'company_name' => $request->company_name ?? null,
            'rc_number' => $request->rc_number ?? null,
            'company_address' => $request->company_address ?? null,
            'region' => $request->region,
            'state' => $request->state ?? null,
            'lga' => $request->lga ?? null,
            'country' => $request->country ?? 'Nigeria',
        ];
    
        UserDetails::create($userDetailsData);
    
        // Trigger the Registered event
        event(new Registered($user));
    
        // Assign the default role to the user
        $user->assignRole($request->default_role);
    
        // Generate a token for the user (optional, for immediate authentication)
        $token = $user->createToken('auth_token')->plainTextToken;
    
        // Return a JSON response
        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token, 
        ], 201); // 201 Created
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
