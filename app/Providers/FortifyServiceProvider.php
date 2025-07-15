<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

// Jika Anda menonaktifkan fitur ini di config/jetstream.php dan config/fortify.php,
// Anda bisa menghapus use statements ini jika tidak digunakan di tempat lain.
// use App\Actions\Fortify\CreateNewUser;
// use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
// use App\Actions\Fortify\UpdateUserProfileInformation;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Set kolom username sebagai credential utama
    $this->app->bind(UpdatesUserPasswords::class, UpdateUserPassword::class);
    // Gunakan view 'welcome' sebagai halaman login
    Fortify::loginView(function () {
        return view('welcome');
    });

    // Otentikasi kustom menggunakan kolom 'username'
    Fortify::authenticateUsing(function (Request $request) {
    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        return $user;
    }

    return null;
    });

    // Rate limiter
    RateLimiter::for('login', function (Request $request) {
        $throttleKey = Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());
        return Limit::perMinute(5)->by($throttleKey);
    });

    RateLimiter::for('two-factor', function (Request $request) {
        return Limit::perMinute(5)->by($request->session()->get('login.id'));
    });
    }

}
