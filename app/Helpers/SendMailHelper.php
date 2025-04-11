<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendNotificationMail;
use App\Mail\ReceiveNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SendMailHelper
{
    public static function sendNotificationMail($data, $request, $userDepartment, $userTenant)
    {
        $senderName = Auth::user()->name;
        $receiverName = User::find($request->recipient_id[0])?->name;
        $documentName = $request->title;
        $documentId = $request->document_number;
        $appName = config('app.name');
        Mail::to(Auth::user()->email)->send(new SendNotificationMail($senderName, $receiverName,  $documentName, $appName, $userDepartment, $userTenant ));
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
                    $appName,
                    $userDepartment,
                    $userTenant

                ));
            }
        }
    }

    public static function sendReviewNotificationMail($data, $recipient, $userDepartment, $userTenant)
    {   
        $senderName = Auth::user()->name;
        $receiverName = User::find($recipient->id)?->name;
        $documentName = $data['document']['title'];
        $documentId = $data['document']['docuent_number'];
        $appName = config('app.name');
        Mail::to(Auth::user()->email)->send(new SendNotificationMail($senderName, $receiverName,  $documentName, $appName, $userDepartment, $userTenant ));

        // Notify each recipient
        $recipientId = $recipient->id;
            $receiver = User::find($recipientId);
            if ($receiver) {
                Mail::to($receiver->email)->send(new ReceiveNotificationMail(
                    $senderName,
                    $receiver->name,
                    $documentName,
                    $documentId,
                    $appName,
                    $userDepartment,
                    $userTenant
                ));
            }
        
    }
}
