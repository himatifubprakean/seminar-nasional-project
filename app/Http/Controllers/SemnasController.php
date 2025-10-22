<?php

namespace App\Http\Controllers;
use App\Models\Peserta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use App\Mail\PesertaEmail;

class SemnasController extends Controller
{
    //
    public function ShowScanPage(){
        return view('scan');
    }

    public function SendBulkEmail(){
        try {
            $peserta = Peserta::whereNotNull('email')->get();
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($peserta as $p) {
                try {
                    
                    $qrCode = QrCode::format('png')
                        ->size(300)
                        ->generate($p->qr_hash);

                    
                    $fileName = 'qrcodes/' . $p->qr_hash . '.png';
                    Storage::disk('public')->put($fileName, $qrCode);
                    $qrCodePath = Storage::disk('public')->path($fileName);

                    
                    Mail::to($p->email)->send(new PesertaEmail($p, $qrCodePath));

                    
                    Storage::disk('public')->delete($fileName);

                    $successCount++;

                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Gagal kirim ke {$p->email}: " . $e->getMessage();
                }
            }

            $message = "Berhasil mengirim {$successCount} email QR Code";
            if ($errorCount > 0) {
                $message .= ", {$errorCount} gagal";
                session()->flash('email_errors', $errors);
            }

            return redirect()->back()->with('success', $message);
            
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function deleteAllParticipant(){
        try{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('peserta')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        return redirect()->back()->with('success', 'Semua peserta berhasil dihapus');
    } catch(\Exception $e){
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
    }

}
