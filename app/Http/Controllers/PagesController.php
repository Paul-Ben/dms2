<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function contactPage()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // Validate form inputs
        $appName = config('app.name');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Send email using Laravel Mailable
        Mail::to('info@bdic.ng')->send(new ContactFormMail($request->all(), $appName));

        $notification = array(
            'message' => 'Your message has been sent successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

}
