<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataset;

class DashboardController extends Controller
{
    public function index()
    {
        // Total jumlah siswa
        $jumlahSiswa = Dataset::count();

        // Hitung berdasarkan nilai `hasil_akhir` (berisi kombinasi huruf: V, A, K, dst)
        $jumlahVisual = Dataset::where('hasil_akhir', 'like', '%V%')->count();
        $jumlahAuditori = Dataset::where('hasil_akhir', 'like', '%A%')->count();
        $jumlahKinestetik = Dataset::where('hasil_akhir', 'like', '%K%')->count();

        return view('dashboard', compact(
            'jumlahSiswa',
            'jumlahVisual',
            'jumlahAuditori',
            'jumlahKinestetik'
        ));
    }
}
