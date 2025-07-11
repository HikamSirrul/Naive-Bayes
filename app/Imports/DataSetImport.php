<?php

namespace App\Imports;

use App\Models\Dataset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class DataSetImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
     * Mulai membaca dari baris ke-4
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
        // Validasi: cek jika data tidak lengkap atau nama kosong
        if (count($row) < 22 || !isset($row[1]) || trim($row[1]) === '' || strtolower(trim($row[1])) === 'nama') {
            return null;
        }

        return new Dataset([
            'nama'              => $row[1],
            'kelas'             => $row[2],
            'v1'                => $row[3],
            'v2'                => $row[4],
            'v3'                => $row[5],
            'v4'                => $row[6],
            'v5'                => $row[7],
            'hasil_visual'      => $row[8],
            'a6'                => $row[9],
            'a7'                => $row[10],
            'a8'                => $row[11],
            'a9'                => $row[12],
            'a10'               => $row[13],
            'hasil_auditori'    => $row[14],
            'k11'               => $row[15],
            'k12'               => $row[16],
            'k13'               => $row[17],
            'k14'               => $row[18],
            'k15'               => $row[19],
            'hasil_kinestetik'  => $row[20],
            'hasil_akhir'       => $row[21],
        ]);
    }
}
