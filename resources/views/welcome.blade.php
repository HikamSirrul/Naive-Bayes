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

    {{-- <header>
        <div class="nav-container">
            <h1>Naive Bayes Classifier</h1>
        </div>
    </header> --}}

    <main
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-300 via-indigo-200 to-purple-300 p-4">
        <div
            class="backdrop-blur-xl bg-white/50 border border-white/30 rounded-2xl shadow-xl flex w-full max-w-5xl h-[60vh] overflow-hidden">
            <!-- KIRI: Konten gambar & tulisan -->
            <div
                class="w-1/2 bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-8 flex flex-col justify-center items-center">
                <h2 class="text-3xl font-semibold mb-4 text-center">Naive Bayes Classifier</h2>
                <p class="text-center text-sm leading-relaxed">Aplikasi ini membantu Anda memahami minat belajar siswa
                    melalui metode <strong>Naive Bayes</strong> secara akurat dan mudah.</p>
            </div>

            <!-- KANAN: Form Login -->
            <div class="w-1/2 p-10 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 border border-red-400 rounded px-4 py-3 mb-2 text-sm">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="bg-green-100 text-green-800 px-4 py-3 rounded text-sm mb-2">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <label for="username" class="block text-gray-700 font-semibold mb-1">Username</label>
                        <input type="text" name="username" id="username" required autofocus autocomplete="username"
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-white/70 backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ old('username') }}">
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                        <input type="password" name="password" id="password" required autocomplete="current-password"
                            class="w-full border border-gray-300 rounded px-3 py-2 bg-white/70 backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>


    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>
