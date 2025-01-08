<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMailNotification;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            $notification = [
                'message' => 'Email already verified.',
                'alert-type' => 'info'
            ];
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1')->with($notification);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            $user = $request->user();
            $recipientMail = $user->email;
            $recipientName = $user->name;
            $appName = config('app.name');
            $contactMail = 'efiling@bdic.ng';
            Mail::to($recipientMail)->send(new WelcomeMailNotification($recipientName, $appName,  $contactMail));
        }
        $notification = [
            'message' => 'Email Verification Successful.',
            'alert-type' => 'success'
        ];
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1')->with($notification);
    }

   
}
