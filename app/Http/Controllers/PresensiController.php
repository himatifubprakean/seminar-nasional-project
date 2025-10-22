<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Peserta;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class PresensiController extends Controller
{
    /**
     * Proses absen berdasarkan QR Code
     */
    public function absen(Request $request)
    {
        $request->validate([
            'qr_hash' => 'required|string'
        ]);

        $qrHash = $request->qr_hash;

        // Cari peserta berdasarkan QR hash
        $peserta = Peserta::where('qr_hash', $qrHash)->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak valid.');
        }

        // Cek apakah sudah absen hari ini
        $today = now()->format('Y-m-d');
        $alreadyAbsen = Presensi::where('peserta_id', $peserta->id)
            ->whereDate('waktu_absen', $today)
            ->exists();

        if ($alreadyAbsen) {
            return redirect()->back()->with('error', 'Peserta sudah melakukan absen hari ini.');
        }

        // Simpan presensi
        Presensi::create([
            'peserta_id' => $peserta->id,
            'waktu_absen' => now(),
            'status' => 'hadir'
        ]);

        return redirect()->back()->with('success', 'Presensi berhasil disimpan.');
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
        $alreadyAbsen = Presensi::where('peserta_id', $peserta->id)
            ->whereDate('waktu_absen', $today)
            ->exists();

        if ($alreadyAbsen) {
            return redirect()->back()->with('error', 'Peserta sudah melakukan absen hari ini.');
        }

        Presensi::create([
            'peserta_id' => $peserta->id,
            'waktu_absen' => now(),
            'status' => 'hadir'
        ]);

        return redirect()->back()->with('success', 'Absen manual berhasil disimpan.');
    }

    /**
     * Tampilkan daftar hadir
     */
    public function showDaftarHadir()
    {
        $presensi = Presensi::with('peserta')
            ->orderBy('waktu_absen', 'desc')
            ->get();

        return view('daftar_hadir', compact('presensi'));
    }
}
