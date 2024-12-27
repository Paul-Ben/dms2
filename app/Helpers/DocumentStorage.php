<?php

namespace App\Helpers;

use App\Models\Activity;
use App\Models\Document;
use App\Models\DocumentRecipient;
use App\Models\FileMovement;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocumentStorage
{
    /**Document count for dashboard view */
    public static function documentCount()
    {
        $received_documents_count = FileMovement::with(['document_recipients', 'document'])
            ->where('recipient_id', Auth::user()->id)->count();
        $sent_documents_count = FileMovement::with(['document_recipients', 'document'])
            ->where('sender_id', Auth::user()->id)->count();

        $uploaded_documents_count = Document::where('uploaded_by', Auth::user()->id)->count();
        return [
            $received_documents_count,
            $sent_documents_count,
            $uploaded_documents_count,
        ];
    }

    /**
     * Get all documents for the logged in user
     */
    public static function myDocuments($perpage = 10)
    {
        $documents = Document::with('user')->where('uploaded_by', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate($perpage);

        return $documents;
    }

    /**
     * Store document in the database
     */
    public static function storeDocument($data)
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

        Document::create([
            'title' => $data->title,
            'docuent_number' => $data->document_number,
            'file_path' => $data->file_path,
            'uploaded_by' => Auth::user()->id,
            // 'department_id' => $user_details->department_id,
            // 'tenant_id' => $user_details->tenant_id,
            'status' => $data->status ?? 'pending',
            'description' => $data->description,
            'metadata' => json_encode($data->metadata),
        ]);

        Activity::create([
            'action' => 'You uploaded a document',
            'user_id' => Auth::user()->id,
        ]);

        return [
            'status' => 'success',
            'message' => 'Document submitted successfully!',
        ];
    }

    /**
     * Get a single document
     */
    public static function getDocument($document)
    {
        $tenantId = $document->tenant_id;
        $departmentId = $document->department_id;
        $filePath = $document->file_path;

        $path = public_path('documents/' . $filePath);

        if (file_exists($path)) {
            return response()->file($path);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'File not found',
        ], 404);
    }

    /**
     * Send document to a recipient
     */
    public static function sendDocument($data)
    {
        $data->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
        ]);


        $document_action = FileMovement::create([
            'recipient_id' => $data->recipient_id,
            'sender_id' => Auth::user()->id,
            'message' => $data->message,
            'document_id' => $data->document_id,
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

    /**
     * Get all sent documents
     */
    public static function getSentDocuments($perPage = 5)
    {
        try {
            // Eager load both relationships and paginate the results
            $sent_documents = FileMovement::with(['document_recipients', 'document'])
                ->where('sender_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            // Fetch recipient details for each sent document
            foreach ($sent_documents as $key => $value) {
                $recipient = User::where('id', $value->recipient_id)->get(['name', 'email']);
                // You can attach recipient details to the document if needed
                $value->recipient_details = $recipient; // Optional: Attach recipient details
            }

            return [$sent_documents, $recipient];

            // return [$sent_documents, $recipient];
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error retrieving received documents: ' . $e->getMessage());
            // Return an empty collection and null sender details
            return [collect(), null];
        }
    }

    /**
     * Get all received documents
     */
    public static function getReceivedDocuments($perPage = 5)
    {
        try {
            // Eager load both relationships and paginate the results
            $received_documents = FileMovement::with(['document_recipients', 'document'])
                ->where('recipient_id', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            // Fetch sender details for each received document
            foreach ($received_documents as $key => $value) {
                $sender = User::where('id', $value->sender_id)->get(['name', 'email']);
                // You can attach sender details to the document if needed
                $value->sender_details = $sender; // Optional: Attach sender details
            }
            return [$received_documents, $sender];
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error retrieving received documents: ' . $e->getMessage());
            // Return an empty collection and null sender details
            return [collect(), null];
        }
    }
}
