<?php

namespace App\Helpers;

use App\Models\Activity;
use App\Models\Document;
use App\Models\DocumentRecipient;
use App\Models\FileMovement;
use App\Helpers\PDF;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use setasign\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;

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
            $tempFilePath = $filePath->getPathname();

            if ($filePath->getMimeType() === 'application/pdf') {
                $pdf = new PDF();

                $pageCount = $pdf->setSourceFile($tempFilePath);

                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($templateId);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($templateId);

                   
                    $pdf->SetFont('Arial', 'B', 14); 
                    $pdf->SetTextColor(0, 128, 0); // Green text color
                    $pdf->SetDrawColor(0, 128, 0); // Green border color
                    $pdf->SetFillColor(255, 255, 255); // White background

                    // Calculate box width and height
                    $boxWidth = 100;
                    $boxHeight = 20; // Adjust height to fit both lines

                    // Position the box
                    $pdf->SetXY(55, 140); // Center position (adjust coordinates as needed)

                    // Add the combined text in a single box
                    $pdf->MultiCell(
                        $boxWidth,
                        $boxHeight / 2, // Line height for each line
                        "RECEIVED\n" . date('Y-m-d H:i:s'), // Text with newline
                        1, // Border
                        'C', // Center alignment
                        true // Fill background
                    );
                    $pdf->SetAlpha(0.5); // Semi-transparent
                }

                $watermarkedFilePath = public_path('documents/' . $filename);
                $pdf->Output($watermarkedFilePath, 'F');

                $data->file_path = $filename;
            } else {
                $file_path = $filePath->move(public_path('documents/'), $filename);
                $data->file_path = $filename;
            }
        }

        Document::create([
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
            'recipient_id' => 'required|array', // Validate that it's an array
            'recipient_id.*' => 'exists:users,id',
            // 'recipient_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
        ]);

        foreach ($data->recipient_id as $recipient) {
            $document_action = FileMovement::create([
                'recipient_id' => $recipient,
                'sender_id' => Auth::user()->id,
                'message' => $data->message,
                'document_id' => $data->document_id,
            ]);

            DocumentRecipient::create([
                'file_movement_id' => $document_action->id,
                'recipient_id' => $recipient,
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
                    'user_id' => $recipient,
                    'created_at' => now(),
                ],
            ]);
        }
        return [
            'status' => 'success',
            'message' => 'Document sent successfully!',
        ];
    }

    protected function send_mails()
    {
        // Send email to recipient
        // $this->send_email($data->recipient_id, $data->document_id);

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
                $recipient = User::with('userDetail.tenant')->where('id', $value->recipient_id)->get(['id', 'name', 'email']);
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
                $value->sender_details = User::select('name', 'email')->find($value->sender_id);
            }

            return [$received_documents];
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error retrieving received documents: ' . $e->getMessage());
            // Return an empty collection and null sender details
            return [collect(), null];
        }
    }

    /**
     * Get single document details
     */
    public static function getDocumentDetails($received)
    {
        $document = Document::with('user')->find($received);
        // dd($document);
        return $document;
    }

    public static function getUserRecipients()
    {
        $adminWithTenantDetails = User::where('default_role', 'Admin')
            ->whereHas('userDetail', function ($query) {
                $query->whereNotNull('tenant_id');
            })
            ->with(['userDetail.tenant'])
            ->get()
            ->map(function ($user) {
                return [
                    'admin_id' => $user->id,
                    'tenant_id' => $user->userDetail->tenant->id ?? null,
                    'tenant_name' => $user->userDetail->tenant->name ?? null,
                ];
            });

        return $adminWithTenantDetails;
    }
}
