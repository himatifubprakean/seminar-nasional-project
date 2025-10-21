<?php

namespace App\Imports;

use App\Models\Peserta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PesertaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $counter = 1;
        $participant_code = "";
        foreach ($rows as $row) {
            
            if (empty($row['nama'])) {
                continue;
            }



            $qrHash = Str::uuid()->toString();
            $participant_code = "SEMNAS-00".str_pad($counter,2,'0',STR_PAD_LEFT)."-2025";
            
            try{

                $result = DB::transaction(function() use($row,$qrHash,$participant_code) {
                    Peserta::create([
                    'name' => $row['nama'],
                    'email' => $row['email'] ?? null,
                    'nomor_peserta'=>$participant_code,
                    'phone' => $row['no_handphone'] ?? null,
                    'qr_hash' => $qrHash,
                
                    ]);
                });
                $counter = $counter + 1;

            }catch(\Throwable $e){
                dd($e);
            }
        }
    }
}