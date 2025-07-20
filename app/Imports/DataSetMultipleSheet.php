<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\DataSetImport; // <--- ini penting

class DataSetMultipleSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new DataSetImport(), // Sheet pertama (4A)
        ];
    }
}
