<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
</head>
<body>

    <header>
        <div class="nav-container">
            <h1>Naive Bayes Classifier</h1>
        </div>
    </header>

    <main class="content">
        <div class="login-container">
            <h2>Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf <!-- Ini harus ada untuk keamanan CSRF -->

                <!-- Menampilkan pesan error validasi dari Fortify/Jetstream -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 border border-red-400 rounded px-4 py-3 mb-4 text-center">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Menampilkan pesan status (misal: setelah password reset, dll.) -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <!-- Penting: name="username" jika Anda mengonfigurasi Fortify untuk username.
                         Jika tidak, gunakan name="email" dan ubah label menjadi "Email". -->
                    <input type="text" class="form-control form-control-lg" id="username" name="username" value="{{ old('username') }}" required autofocus autocomplete="username">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn btn-primary">Masuk</button>

            </form>
        </div>
    </main>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>
</html>
