<?php

namespace App\Helpers;

use App\Models\Activity;
use App\Models\Document;
use App\Models\DocumentRecipient;
use App\Models\FileMovement;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;

class UserFileDocument
{
    public static function userFileDocument($data)
    {
        
        $documentId = self::store($data);

        self::sendDocument($data, $documentId);
    }
    protected static function store($data)
    {
        $data->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'metadata' => 'nullable|json',
        ]);

        if ($data->hasFile('file_path')) {
            $filePath = $data->file('file_path');
            $filename = time() . '_' . $filePath->getClientOriginalName();
            $file_path = $filePath->move(public_path('documents/'), $filename);
            $data->file_path = $filename;
        }
        $user_details = UserDetails::where('user_id', Auth::user()->id)->first();

        $document = Document::create([
            'title' => $data->title,
            'docuent_number' => $data->document_number,
            'file_path' => $data->file_path,
            'uploaded_by' => Auth::user()->id,
            'status' => $data->status ?? 'pending',
            'description' => $data->description,
            'metadata' => json_encode($data->metadata),
        ]);

        Activity::create([
            'action' => 'You uploaded a document',
            'user_id' => Auth::user()->id,
        ]);

        return $document->id;
    }
    protected static function sendDocument($data, $documentId)
    {
        $data->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
        ]);


        $document_action = FileMovement::create([
            'recipient_id' => $data->recipient_id,
            'sender_id' => Auth::user()->id,
            'message' => $data->description,
            'document_id' => $documentId,
        ]);

        DocumentRecipient::create([
            'file_movement_id' => $document_action->id,
            'recipient_id' => $data->recipient_id,
            'user_id' => Auth::user()->id,
            'created_at' => now(),
        ]);

        Activity::insert([
            [
                'action' => 'Sent Document',
                'user_id' => Auth::user()->id,
                'created_at' => now(),
            ],
            [
                'action' => 'Document Received',
                'user_id' => $data->recipient_id,
                'created_at' => now(),
            ],
        ]);

        return [
            'status' => 'success',
            'message' => 'Document sent successfully!',
        ];
    }
}