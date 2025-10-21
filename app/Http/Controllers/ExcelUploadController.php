<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\PesertaImport;

class ExcelUploadController extends Controller
{
    public function index()
    {
        return view('upload_excel');
    }

    public function ImportExcel(Request $request){

        $request->validate([
            'excel_file' =>'required|mimes:xlsx,xls'
        ]);

        
        
        try{
            Excel::import(new PesertaImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Data berhasil diimport !');

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }

    }

    
}
