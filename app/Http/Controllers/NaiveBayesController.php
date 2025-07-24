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
        $activeTab         = $request->input('activeTab', 'dataset');
        $percentageDisplay = (int) $request->input('percentage_display', 50);
        $percentageDisplay = max(10, min(90, $percentageDisplay));

        // Ambil semua data dan hitung hasil akhir
        $allData = Dataset::all()->map(function ($siswa) {
            $scores = [
                'V' => $siswa->hasil_visual,
                'A' => $siswa->hasil_auditori,
                'K' => $siswa->hasil_kinestetik,
            ];

            $max = max($scores);
            $dominant = array_keys($scores, $max);
            $siswa->akhir = implode('', $dominant);

            return $siswa;
        });

        $totalSiswaFix = $allData->count();
        $jumlahTampil  = (int) round($totalSiswaFix * ($percentageDisplay / 100));
        if ($jumlahTampil === 0 && $totalSiswaFix > 0) {
            $jumlahTampil = 1;
        }

        // Ambil data training dan testing
        $filteredDatasets = $allData->shuffle()->take($jumlahTampil); // Training
        $testingDatasets  = $allData->diff($filteredDatasets);        // Testing
        $jumlahTesting    = $testingDatasets->count();

        if ($activeTab === 'performance') {
            $testingDatasets = $testingDatasets->filter(fn($d) => in_array($d->akhir, ['V', 'A', 'K']))->values();
            $jumlahTesting = $testingDatasets->count();
        }

        // Data training: hanya minat tunggal
        $dataTunggalTraining = $filteredDatasets->filter(fn($d) => in_array($d->akhir, ['V', 'A', 'K']))->values();
        $jumlahValidTraining = $dataTunggalTraining->count();

        $jumlahVisual     = $dataTunggalTraining->filter(fn($d) => $d->akhir === 'V')->count();
        $jumlahAuditori   = $dataTunggalTraining->filter(fn($d) => $d->akhir === 'A')->count();
        $jumlahKinestetik = $dataTunggalTraining->filter(fn($d) => $d->akhir === 'K')->count();
        $jumlahGabungan   = $filteredDatasets->filter(fn($d) => strlen($d->akhir) >= 2)->count();

        // Hitung persentase berdasarkan jumlah data tunggal saja
        $persentaseVisual     = $jumlahValidTraining ? round(($jumlahVisual / $jumlahValidTraining) * 100, 2) : 0;
        $persentaseAuditori   = $jumlahValidTraining ? round(($jumlahAuditori / $jumlahValidTraining) * 100, 2) : 0;
        $persentaseKinestetik = $jumlahValidTraining ? round(($jumlahKinestetik / $jumlahValidTraining) * 100, 2) : 0;
        $persentaseGabungan   = $jumlahTampil ? round(($jumlahGabungan / $jumlahTampil) * 100, 2) : 0;

        if ($request->ajax() || $request->wantsJson()) {
            return Response::json([
                'jumlahSiswaYangDitampilkan' => $jumlahTampil,
                'percentageDisplay'          => $percentageDisplay,
                'jumlahTesting'              => $jumlahTesting,

                'jumlahVisual'     => $jumlahVisual,
                'jumlahAuditori'   => $jumlahAuditori,
                'jumlahKinestetik' => $jumlahKinestetik,
                'jumlahGabungan'   => $jumlahGabungan,

                'persentaseVisual'     => $persentaseVisual,
                'persentaseAuditori'   => $persentaseAuditori,
                'persentaseKinestetik' => $persentaseKinestetik,
                'persentaseGabungan'   => $persentaseGabungan,
            ]);
        }

        return view('naive-bayes-page', [
            'allData'                     => $allData,
            'activeTab'                   => $activeTab,
            'jumlahSiswaYangDitampilkan' => $jumlahTampil,
            'jumlahTesting'              => $jumlahTesting,
            'percentageDisplay'          => $percentageDisplay,

            'jumlahVisual'     => $jumlahVisual,
            'jumlahAuditori'   => $jumlahAuditori,
            'jumlahKinestetik' => $jumlahKinestetik,
            'jumlahGabungan'   => $jumlahGabungan,

            'persentaseVisual'     => $persentaseVisual,
            'persentaseAuditori'   => $persentaseAuditori,
            'persentaseKinestetik' => $persentaseKinestetik,
            'persentaseGabungan'   => $persentaseGabungan,

            'filteredDatasets' => $filteredDatasets,
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
