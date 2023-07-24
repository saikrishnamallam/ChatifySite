<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PdfFile;

class PdfFileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:5000', // Validate that only PDF files are allowed and the file size is up to 2MB.
        ]);

        $file = $request->file('pdf_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pdf_files', $filename, 'public');

        // Save the file information to the database
        $pdfFile = new PdfFile([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);
        $pdfFile->save();

        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function readData($id)
    {
        $pdfFile = PdfFile::findOrFail($id);

        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Read data from the PDF file using the 'getTextFromPage' method
        $pdfPath = storage_path('app/public/' . $pdfFile->path);
        $page = 1; // Choose the page number you want to read from (1-based index)
        $pdf->setSourceFile($pdfPath);
        $text = $pdf->getTextFromPage($page);

        return response()->json(['data' => $text]);
    }
}
