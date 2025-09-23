<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactAPIController extends Controller
{
    /**
     * Submit contact form
     */
    public function submit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:2000',
                'phone' => 'nullable|string|max:20'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $contactData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'phone' => $request->phone,
                'submitted_at' => now()
            ];

            // Send email notification
            try {
                $adminEmail = config('mail.admin_email', 'admin@example.com');
                $appName = config('app.name', 'DMS');
                Mail::to($adminEmail)->send(new ContactFormMail($contactData, $appName));
            } catch (\Exception $mailException) {
                // Log the mail error but don't fail the request
                Log::error('Contact form mail failed: ' . $mailException->getMessage());
            }

            return response()->json([
                'message' => 'Contact form submitted successfully. We will get back to you soon.',
                'data' => $contactData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to submit contact form. Please try again later.'
            ], 500);
        }
    }

    /**
     * Get contact information
     */
    public function getContactInfo()
    {
        try {
            $contactInfo = [
                'email' => config('mail.admin_email', 'admin@example.com'),
                'phone' => config('app.contact_phone', '+234-XXX-XXX-XXXX'),
                'address' => config('app.contact_address', 'Your Organization Address'),
                'office_hours' => config('app.office_hours', 'Monday - Friday: 8:00 AM - 5:00 PM'),
                'support_email' => config('app.support_email', 'support@example.com')
            ];

            return response()->json([
                'contact_info' => $contactInfo
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch contact information'
            ], 500);
        }
    }
}