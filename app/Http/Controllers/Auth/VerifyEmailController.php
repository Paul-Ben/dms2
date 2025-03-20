<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMailNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

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
            $contactMail = 'info@edms.benuestate.gov.ng';
            try{
                 Mail::to($recipientMail)->send(new WelcomeMailNotification($recipientName, $appName,  $contactMail));
            }catch(\Exception $e){
                Log::error($e->getMessage());
            }
           
        }
        $notification = [
            'message' => 'Email Verification Successful.',
            'alert-type' => 'success'
        ];
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1')->with($notification);
    }

   
}
