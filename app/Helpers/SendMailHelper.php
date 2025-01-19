<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendNotificationMail;
use App\Mail\ReceiveNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SendMailHelper
{
    public static function sendNotificationMail($data, $request)
    {
        $senderName = Auth::user()->name;
        $receiverName = User::find($request->recipient_id[0])?->name;
        $documentName = $request->title;
        $documentId = $request->document_number;
        $appName = config('app.name');
        Mail::to(Auth::user()->email)->send(new SendNotificationMail($senderName, $receiverName,  $documentName, $appName));
        // Mail::to(User::find($data->recipient_id)?->email)->send(new ReceiveNotificationMail($senderName, $receiverName, $documentName, $documentId, $appName));
        // Notify each recipient
        foreach ($request->recipient_id as $recipientId) {
            $receiver = User::find($recipientId);
            if ($receiver) {
                Mail::to($receiver->email)->send(new ReceiveNotificationMail(
                    $senderName,
                    $receiver->name,
                    $documentName,
                    $documentId,
                    $appName
                ));
            }
        }
    }

    public static function sendReviewNotificationMail($data, $recipient)
    {   
        $senderName = Auth::user()->name;
        $receiverName = User::find($recipient[0]->id)?->name;
        $documentName = $data['document']['title'];
        $documentId = $data['document']['docuent_number'];
        $appName = config('app.name');
        Mail::to(Auth::user()->email)->send(new SendNotificationMail($senderName, $receiverName,  $documentName, $appName));

        // Notify each recipient
        $recipientId = $recipient[0]->id;
            $receiver = User::find($recipientId);
            if ($receiver) {
                Mail::to($receiver->email)->send(new ReceiveNotificationMail(
                    $senderName,
                    $receiver->name,
                    $documentName,
                    $documentId,
                    $appName
                ));
            }
        
    }
}
