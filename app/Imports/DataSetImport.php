<?php

namespace App\Imports;

use App\Models\Dataset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class DataSetImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
     * Mulai membaca dari baris ke-4 (jika header ada di baris 3)
     */
    public function startRow(): int
    {
        return 4;
    }

    /**
     * Mapping data per baris ke dalam model Dataset
     */
    public function model(array $row)
    {
        // Validasi: jika jumlah kolom kurang atau nama kosong, abaikan
        if (count($row) < 23 || !isset($row[1]) || trim($row[1]) === '' || strtolower(trim($row[1])) === 'nama') {
            return null;
        }

        return new Dataset([
            'nama'              => $row[1],
            'jenis_kelamin'     => $row[2],
            'kelas'             => $row[3],
            'v1'                => $row[4],
            'v2'                => $row[5],
            'v3'                => $row[6],
            'v4'                => $row[7],
            'v5'                => $row[8],
            'hasil_visual'      => $row[9],
            'a6'                => $row[10],
            'a7'                => $row[11],
            'a8'                => $row[12],
            'a9'                => $row[13],
            'a10'               => $row[14],
            'hasil_auditori'    => $row[15],
            'k11'               => $row[16],
            'k12'               => $row[17],
            'k13'               => $row[18],
            'k14'               => $row[19],
            'k15'               => $row[20],
            'hasil_kinestetik'  => $row[21],
            'hasil_akhir'       => $row[22],
        ]);
    }
}
