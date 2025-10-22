<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Daftar_hadir;
use App\Models\Peserta;



use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;


class PresensiController extends Controller
{
    //


    // public function generateQRCode($pesertaId){
    //     $peserta = Peserta::findOrFail($pesertaId);

    //     $qrCode = QrCode::format('png')
    //                         ->size(200)
    //                         ->generate($peserta->qr_hash);
    //     return response($qrCode)->header('Content-type', 'image/png');
    // }

    // public function absen(Request $request)
    // {
    //     $request->validate([
    //         'qr_hash' => 'required|string'
    //     ]);

    //     $qrHash = $request->qr_hash;
        
    //     // Cari peserta berdasarkan QR hash
    //     $peserta = Peserta::where('qr_hash', $qrHash)->first();

    //     if (!$peserta) {
    //         return redirect()->back()->with('error', 'Error: ' . 'Peserta Tidak Valid');
    //     }

    //     // Cek apakah sudah absen hari ini
    //     $today = now()->format('Y-m-d');
    //     $alreadyAbsen = Presensi::where('id_peserta', $peserta->id)
    //         ->whereDate('waktu_hadir', $today)
    //         ->exists();

    //     if ($alreadyAbsen) {
    //         return redirect()->back()->with('error', 'Error: ' . 'Peserta Telah Melakukan Absen');
    //     }

    //     // Simpan presensi
    //     Presensi::create([
    //         'peserta_id' => $peserta->id,
    //         'waktu_absen' => now(),
    //         'status' => 'hadir'
    //     ]);

    //     return redirect()->back()->with('success', 'Presensi Berhasil!');
    // }

    public function absen(Request $request)
    {
        $request->validate([
            'qr_hash' => 'required|string'
        ]);

        $qrHash = $request->qr_hash;
        
        // Cari peserta berdasarkan QR hash
        $peserta = Peserta::where('qr_hash', $qrHash)->first();

        if (!$peserta) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peserta Tidak Valid'
                ], 404);
            }
            return redirect()->back()->with('error', 'Error: ' . 'Peserta Tidak Valid');
        }

        // Cek apakah sudah absen hari ini
        $today = now()->format('Y-m-d');
        $alreadyAbsen = Daftar_hadir::where('id_peserta', $peserta->id) // Perhatikan: ini harus 'peserta_id' konsisten
            ->whereDate('waktu_hadir', $today) // Perhatikan: ini 'waktu_absen' bukan 'waktu_hadir'
            ->exists();

        if ($alreadyAbsen) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peserta Telah Melakukan Absen'
                ], 400);
            }
            return redirect()->back()->with('error', 'Error: ' . 'Peserta Telah Melakukan Absen');
        }

        // Simpan presensi
        Daftar_hadir::create([
            'id_peserta' => $peserta->id,
            'waktu_hadir' => now(),
            'status' => 'hadir'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Presensi Berhasil!',
                'data' => [
                    'nama' => $peserta->nama, // Pastikan field 'nama' ada di model Peserta
                    'waktu' => now()->format('d/m/Y H:i:s')
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Presensi Berhasil!');
    }

    public function manualAbsen(Request $request){
        $request->validate([
            "nomor_peserta"=>'required|string'
        ]);


        $peserta = Peserta::where('nomor_peserta',$request['nomor_peserta'])->first();

        if(!$peserta){
            return redirect()->back()->with('error', 'Error:'.'Peserta tidak ditemukan');
        }
        $alreadyAbsen = Daftar_hadir::where('id_peserta', $peserta->id);

        if($alreadyAbsen){
            return redirect()->back()->with('error', 'Error'. 'Peserta telah melakukan absen');
        }

        Daftar_hadir::create([
            'id_peserta' => $peserta->id,
            'waktu_hadir' => now(),
            'status' => 'hadir'
        ]);
        return redirect()->back()->with('success', 'Presensi Berhasil!');
        
    }
    


}
