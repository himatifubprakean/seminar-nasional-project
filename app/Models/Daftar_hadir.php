<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar_hadir extends Model
{
    //
    use HasFactory;

    protected $table ='daftar_hadir';

    protected $fillable = [
        "id_peserta",
        "waktu_hadir",
        "status"
    ];

    protected $casts = [
        'waktu_hadir' => 'datetime'
    ];

    public function peserta(){
        return $this-belongsTo(Peserta::class);
    }

}
