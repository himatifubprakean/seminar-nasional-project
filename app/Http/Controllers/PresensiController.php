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

    /**
     * Absen manual berdasarkan nomor peserta
     */
    public function manualAbsen(Request $request)
    {
        $request->validate([
            "nomor_peserta" => 'required|string'
        ]);

        $peserta = Peserta::where('nomor_peserta', $request->nomor_peserta)->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan.');
        }

        $today = now()->format('Y-m-d');
        $alreadyAbsen = Daftar_hadir::where('id_peserta', $peserta->id)
            ->whereDate('waktu_hadir', $today)
            ->exists();

        if ($alreadyAbsen) {
            return redirect()->back()->with('error', 'Peserta sudah melakukan absen hari ini.');
        }

        Daftar_hadir::create([
            'id_peserta' => $peserta->id,
            'waktu_hadir' => now(),
            'status' => 'hadir',
            
        ]);
        return redirect()->back()->with('success', 'Presensi Berhasil!');
        
    }

    /**
     * Tampilkan daftar hadir
     */
    public function showDaftarHadir()
    {
        $presensi = Daftar_hadir::with('peserta')
            ->orderBy('waktu_hadir', 'desc')
            ->get();

        return view('daftar_hadir', compact('presensi'));
    }
}
