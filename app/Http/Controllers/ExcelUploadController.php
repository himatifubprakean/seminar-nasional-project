<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExcelUploadController extends Controller
{
    // Halaman form upload
    public function index()
    {
        return view('upload_excel'); 
    }

    // Proses upload
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $path = $file->store('excel_uploads');

        return back()->with('success', 'File berhasil diupload ke: ' . $path);
    }
}
