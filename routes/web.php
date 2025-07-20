<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NaiveBayesController;
use App\Http\Controllers\DashboardController;
use App\Models\Dataset;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
});

Route::get('/api/get-siswa', function (\Illuminate\Http\Request $request) {
    $nama = $request->query('nama');
    $data = Dataset::where('nama', $nama)->first();

    if (!$data) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    return response()->json([
        'jenis_kelamin' => $data->jenis_kelamin,
        'kelas'         => $data->kelas,
        'visual'        => $data->hasil_visual,
        'auditori'      => $data->hasil_auditori,
        'kinestetik'    => $data->hasil_kinestetik,
    ]);
});

Route::get('/api/search-siswa', function (\Illuminate\Http\Request $request) {
    $term = $request->query('term');

    $results = Dataset::where('nama', 'LIKE', '%' . $term . '%')
        ->limit(10)
        ->pluck('nama');

    return response()->json($results);
});

// Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman utama Naive Bayes (mengarah ke controller)
    Route::get('/naive-bayes', [NaiveBayesController::class, 'index'])->name('naive.bayes');

    // Halaman proses awal
    Route::get('/naive-bayes/initial-process', function () {
        return view('data-bayes.initial-process');
    })->name('naive.bayes.initial-process');

    // Halaman performance
    Route::get('/naive-bayes/performance', function () {
        return view('data-bayes.performance');
    })->name('naive.bayes.performance');

    // Halaman prediksi
    Route::get('/naive-bayes/prediction', function () {
        return view('data-bayes.prediction');
    })->name('naive.bayes.prediction');


    // Upload dan hapus data
    Route::post('/naive-bayes/upload-excel', [NaiveBayesController::class, 'uploadDataset'])->name('naive.bayes.upload_excel');
    Route::delete('/naive-bayes/delete-all', [NaiveBayesController::class, 'deleteAll'])->name('naive.bayes.delete_all');
});
