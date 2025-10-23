<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar_hadir extends Model
{
    //
    use HasFactory;

    protected $table ='daftar_hadir';

    protected static function booted()
    {
        static::created(function ($daftarHadir) {
            // Auto-create sertifikat ketika daftar hadir dibuat
            Sertifikat::create([
                'id_daftar_hadir' => $daftarHadir->id,
                'code_unik' => Sertifikat::generateCode($daftarHadir->id_peserta),
                'nama_kegiatan' => 'SEMNAS',
                'status' => 'PESERTA'
            ]);
        });
    }

    protected $fillable = [
        "id_peserta",
        "waktu_hadir",
        "status"
    ];

    protected $casts = [
        'waktu_hadir' => 'datetime'
    ];

    public function peserta(){
        return $this->belongsTo(Peserta::class);
    }

     public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'id_daftar_hadir');
    }

}
