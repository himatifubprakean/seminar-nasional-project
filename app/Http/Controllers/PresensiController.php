<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Daftar_hadir;
use App\Models\Peserta;

use App\Imports\PesertaImport;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;


class PresensiController extends Controller
{
    //

    public function ImportExcel(Request $request){

        $request->validate([
            'file' =>'required|mimes:xlsx,xls'
        ]);
        
        try{
            Excel::import(new PesertaImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data berhasil diimport dan QR Code digenerate!');

        }catch(\Exception $e){
            return redirect()->back()-with('error','Error'. $e->getMessage());
        }

    }

    public function generateQRCode($pesertaId){
        $peserta = Peserta::findOrFail($pesertaId);

        $qrCode = QrCode::format('png')
                            ->size(200)
                            ->generate($peserta->qr_hash);
        return response($qrCode)->header('Content-type', 'image/png');
    }

    public function absen(Request $request)
    {
        $request->validate([
            'qr_hash' => 'required|string'
        ]);

        $qrHash = $request->qr_hash;
        
        // Cari peserta berdasarkan QR hash
        $peserta = Peserta::where('qr_hash', $qrHash)->first();

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau peserta tidak ditemukan.'
            ], 404);
        }

        // Cek apakah sudah absen hari ini
        $today = now()->format('Y-m-d');
        $alreadyAbsen = Presensi::where('peserta_id', $peserta->id)
            ->whereDate('waktu_hadir', $today)
            ->exists();

        if ($alreadyAbsen) {
            return response()->json([
                'success' => false,
                'message' => $peserta->nama . ' sudah melakukan absen hari ini.'
            ], 400);
        }

        // Simpan presensi
        Presensi::create([
            'peserta_id' => $peserta->id,
            'waktu_absen' => now(),
            'status' => 'hadir'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil untuk ' . $peserta->nama,
            'data' => [
                'nama' => $peserta->nama,
                'email' => $peserta->email,
                'waktu' => now()->format('d/m/Y H:i:s')
            ]
        ]);
    }

    public function listPeserta()
    {
        $peserta = Peserta::with(['presensi' => function($query) {
            $query->orderBy('waktu_hadir', 'desc');
        }])->get();

        // return view('peserta-list', compact('peserta'));
    }


}
