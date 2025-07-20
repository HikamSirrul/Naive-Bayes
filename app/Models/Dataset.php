<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kelas','jenis_kelamin',
        'v1', 'v2', 'v3', 'v4', 'v5', 'hasil_visual',
        'a6', 'a7', 'a8', 'a9', 'a10', 'hasil_auditori',
        'k11', 'k12', 'k13', 'k14', 'k15', 'hasil_kinestetik',
        'hasil_akhir',
    ];
}
