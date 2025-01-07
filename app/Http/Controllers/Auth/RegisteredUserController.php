<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => 'required|regex:/^0[0-9]{10}$/',
            'nin_number' => 'required|digits:11',
            'gender' => 'required|in:male,female',
            'account_type' => 'required|in:individual,corporate',
            'company_name' => 'required_if:account_type,corporate|max:255',
            'rc_number' => 'required_if:account_type,corporate|max:255',
            'company_address' => 'required_if:account_type,corporate|max:255',
            'g-recaptcha-response' => 'recaptcha',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'default_role' => $request->default_role,
        ]);


        UserDetails::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'nin_number' => $request->nin_number,
            'designation' => $request->designation,
            'gender' => $request->gender,
            'account_type' => $request->account_type,
            'company_name' => $request->company_name,
            'rc_number' => $request->rc_number,
            'company_address' => $request->company_address,

        ]);

        event(new Registered($user));
        $user->assignRole($request->default_role);
        Auth::login($user);


        return redirect(RouteServiceProvider::HOME);
    }
}
