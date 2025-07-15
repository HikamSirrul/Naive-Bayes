<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Gunakan Hash Facade untuk hashing password
use Illuminate\Validation\ValidationException; // Untuk menangani validasi secara eksplisit jika diperlukan

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        // Request::validate() akan otomatis mengarahkan kembali dengan error jika validasi gagal
        // dan error akan tersedia di $errors variable di Blade.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {
            User::create([
                'username' => $request->name,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Direkomendasikan menggunakan Hash::make()
            ]);

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'User berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Tangani error lain yang mungkin terjadi (misal: koneksi database)
            // Untuk error validasi, Request::validate() sudah menanganinya di atas
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage());
        }
    }
}
