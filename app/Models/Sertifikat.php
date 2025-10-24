<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Sertifikat extends Model
{
    //

    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        "id_daftar_hadir",
        "code_unik",
        "nama_kegiatan",
        "status"
    ];


    public static function generateCode($id_peserta)
    {
        $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $date = date('Ymd');

        return "FIKSEMNASUBP-{$date}-{$randomNumber}-{$id_peserta}";
    }

    public function daftarHadir()
    {
        return $this->belongsTo(DaftarHadir::class, 'id_daftar_hadir');
    }


    public function peserta()
    {
        return $this->hasOneThrough(
            Peserta::class,
            DaftarHadir::class,
            'id',
            'id',
            'id_daftar_hadir',
            'id_peserta'
        );
    }
}
