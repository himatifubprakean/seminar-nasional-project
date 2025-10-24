<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Model
{
    //
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'name',
        'email',
        'nomor_peserta',
        'phone',
        'qr_hash'

    ];

    public function daftar_hadir(){
        return $this->hasMany(DaftarHadir::class, 'id_peserta');
    }
}
