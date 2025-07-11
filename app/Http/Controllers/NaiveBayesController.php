<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataSetMultipleSheet;
use App\Models\Dataset;
use Illuminate\Support\Facades\Response;

class NaiveBayesController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tab aktif & persentase tampilan
        $activeTab         = $request->input('activeTab', 'dataset');
        $percentageDisplay = (int) $request->input('percentage_display', 50);
        $percentageDisplay = max(20, min(90, $percentageDisplay));

        // Ambil semua data ➜ kalkulasi 'akhir'
        $allData = Dataset::all()->map(function ($siswa) {
            $scores = [
                'V' => $siswa->hasil_visual,
                'A' => $siswa->hasil_auditori,
                'K' => $siswa->hasil_kinestetik,
            ];

            $max      = max($scores);
            $dominant = array_keys($scores, $max);

            // Ganti nama properti jadi 'akhir'
            $siswa->akhir = implode('', $dominant);

            return $siswa;
        });

        $totalSiswaFix = $allData->count();
        $jumlahTampil = (int) round($totalSiswaFix * ($percentageDisplay / 100));
        if ($jumlahTampil === 0 && $totalSiswaFix > 0) {
            $jumlahTampil = 1;
        }

        $filteredDatasets = $allData->shuffle()->take($jumlahTampil);

        // Hitung jumlah kategori dari filtered data
        $jumlahVisual = $filteredDatasets->filter(
            fn($d) =>
            str_contains(strtolower($d->akhir), 'v')
        )->count();

        $jumlahAuditori = $filteredDatasets->filter(
            fn($d) =>
            str_contains(strtolower($d->akhir), 'a')
        )->count();

        $jumlahKinestetik = $filteredDatasets->filter(
            fn($d) =>
            str_contains(strtolower($d->akhir), 'k')
        )->count();

        $jumlahGabungan = $filteredDatasets->filter(function ($d) {
            return strlen($d->akhir) >= 2;
        })->count();

        // Hitung persentase
        $persentaseVisual     = $jumlahTampil ? round(($jumlahVisual     / $jumlahTampil) * 100, 2) : 0;
        $persentaseAuditori   = $jumlahTampil ? round(($jumlahAuditori   / $jumlahTampil) * 100, 2) : 0;
        $persentaseKinestetik = $jumlahTampil ? round(($jumlahKinestetik / $jumlahTampil) * 100, 2) : 0;
        $persentaseGabungan   = $jumlahTampil ? round(($jumlahGabungan   / $jumlahTampil) * 100, 2) : 0;

        // Jika request AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return Response::json([
                'jumlahVisual'                 => $jumlahVisual,
                'jumlahAuditori'               => $jumlahAuditori,
                'jumlahKinestetik'             => $jumlahKinestetik,
                'jumlahGabungan'               => $jumlahGabungan,
                'jumlahSiswaYangDitampilkan'   => $jumlahTampil,
                'percentageDisplay'            => $percentageDisplay,
                'persentaseVisual'             => $persentaseVisual,
                'persentaseAuditori'           => $persentaseAuditori,
                'persentaseKinestetik'         => $persentaseKinestetik,
                'persentaseGabungan'           => $persentaseGabungan,
            ]);
        }

        // Return tampilan utama (Blade)
        return view('naive-bayes-page', [
            'allData'                     => $allData,
            'activeTab'                   => $activeTab,
            'jumlahVisual'                => $jumlahVisual,
            'jumlahAuditori'              => $jumlahAuditori,
            'jumlahKinestetik'            => $jumlahKinestetik,
            'jumlahGabungan'              => $jumlahGabungan,
            'jumlahSiswaYangDitampilkan'  => $jumlahTampil,
            'percentageDisplay'           => $percentageDisplay,
            'persentaseVisual'            => $persentaseVisual,
            'persentaseAuditori'          => $persentaseAuditori,
            'persentaseKinestetik'        => $persentaseKinestetik,
            'persentaseGabungan'          => $persentaseGabungan,
            'filteredDatasets'            => $filteredDatasets,
        ]);
    }

    public function deleteAll()
    {
        try {
            Dataset::truncate();
            return redirect()->back()->with('success', 'Semua data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function uploadDataset(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ], [
            'excel_file.required' => 'File Excel wajib diunggah.',
            'excel_file.file'     => 'Yang diunggah harus berupa file.',
            'excel_file.mimes'    => 'Format file harus .xlsx atau .xls.',
            'excel_file.max'      => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        try {
            Excel::import(new DataSetMultipleSheet, $request->file('excel_file'));
            return redirect()->route('naive.bayes', ['activeTab' => 'dataset'])
                ->with('success', 'Data set berhasil diunggah dan diproses!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses data set: ' . $e->getMessage());
        }
    }
}
