<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExcelUploadController extends Controller
{
    public function index()
    {
        return view('upload_excel');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:5120', // max 5MB
        ]);

        // Simpan file ke storage/app/public/uploads
        $path = $request->file('excel_file')->store('uploads', 'public');

        // (Opsional) Baca isi Excel untuk verifikasi
        $data = Excel::toCollection(null, storage_path('app/public/' . $path));

        return back()
            ->with('success', 'File Excel berhasil diunggah!')
            ->with('file_path', $path)
            ->with('preview_data', $data->first()->take(5));
    }
}
