<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PdfFile;
use setasign\Fpdi\Fpdi;

class PdfFileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('pdf_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pdf_files', $filename, 'public');

        // Extract text from the PDF
        $text = $this->extractTextFromPdf(storage_path('app/public/' . $path));

        // Save the PDF file information in the database
        $pdfFile = new PdfFile([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'text_content' => $text,
        ]);
        $pdfFile->save();

        return response()->json(['message' => 'File uploaded successfully']);
    }

    protected function extractTextFromPdf($filePath)
    {
        $pdf = new Fpdi();
        $text = '';
        $numPages = $pdf->setSourceFile($filePath);

        for ($pageNo = 1; $pageNo <= $numPages; $pageNo++) {
            $template = $pdf->importPage($pageNo);
            $text .= $pdf->getText($template);
        }

        return $text;
    }
}
