<?php

namespace App\Helpers;

use App\Models\Document;
use setasign\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;

class StampHelper
{
    public static function stampIncomingMail($documentID)
    {
        $document = Document::find($documentID);

        if (!$documentID) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        // Paths for the original PDF and the output
        $originalPdfPath = storage_path('app/public/' . $document->file_path);
        $documentPath = storage_path( 'app/public/' . $document->file_path);
        $outputPdfPath = storage_path( $document->file_path);

        // Generate QR Code
        // $qrCodePath = storage_path('app/public/qr_codes/document_' . $document->id . '.png');
        // QrCode::format('png')
        //     ->size(150)
        //     ->generate('Document ID: ' . $document->id . ', Title: ' . $document->title, $qrCodePath);

        // Create an instance of FPDI
        $pdf = new Fpdi();

        // Load the PDF
        $pageCount = $pdf->setSourceFile($documentPath);
        // dd($pageCount);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // Import the current page
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            // Add a page with the same dimensions
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Set the font and color for the stamp
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetTextColor(36, 161, 32); // Green color for the stamp36, 161, 32

            // Add the stamp (e.g., CONFIDENTIAL)
            $pdf->SetXY(20, 20); // Position for the stamp
            $pdf->Cell(0, 10, 'RECEIVED', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10); // Set font for the date
            $currentDate = now()->format('F j, Y, g A'); // Define the date
            $pdf->Cell(0, 10, $currentDate, 0, 1, 'C');

            // Add the QR Code
            // $pdf->Image($qrCodePath, 20, $size['height'] - 50, 30, 30); // Position and size of the QR code
        }

        // Save the output PDF
        $pdf->Output($documentPath, 'F');

        // return response()->download($outputPdfPath, 'document_with_stamp_qrcode.pdf');
        return [
            $documentPath,
            'message' => 'Document Stamped',
        ];
    }
}
