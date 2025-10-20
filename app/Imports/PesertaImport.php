<?php

namespace App\Imports;

use App\Models\Peserta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class PesertaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            
            if (empty($row['nama'])) {
                continue;
            }


            $qrHash = Str::uuid()->toString();

            Peserta::create([
                'nama' => $row['nama'],
                'email' => $row['email'] ?? null,
                'no_identitas' => $row['no_identitas'] ?? $row['nomor_identitas'] ?? null,
                'qr_hash' => $qrHash,
            ]);
        }
    }
}