<?php

namespace App\Mail;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PesertaEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $peserta;
    public $qrCodePath;

    public function __construct(Peserta $peserta,$qrCodePath)
    {
        $this->peserta = $peserta;
        $this->qrCodePath = $qrCodePath;
    }

    public function build()
    {
        return $this->subject('QR Code Presensi Seminar Nasional')
                    ->view('emails.peserta')
                    ->attach($this->qrCodePath, [
                        'as' => 'qrcode-' . $this->peserta->nama . '.png',
                        'mime' => 'image/png',
                    ]);
    }
}
