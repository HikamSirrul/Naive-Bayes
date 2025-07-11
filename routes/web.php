<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NaiveBayesController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
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
