{{-- File: resources/views/layouts/naive-bayes.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Naive Bayes Classifier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- HAPUS: max-w-7xl mx-auto sm:px-6 lg:px-8 dari div ini --}}
        {{-- Biarkan div ini mengisi lebar penuh (w-full) atau sesuaikan agar kontennya mengisi --}}
        <div class="w-full bg-white shadow-lg rounded-lg p-0">
            {{-- PENTING: Pindahkan x-data ke div ini yang membungkus SIDEBAR dan KONTEN UTAMA --}}
            {{-- Tambahkan fungsi updateUrl di sini --}}
            <div class="flex flex-col md:flex-row min-h-screen bg-gray-100 rounded-lg"
                x-data="{
                    activeTab: '{{ $activeTab ?? 'dataset' }}',
                    updateUrl(tabName) {
                        this.activeTab = tabName;
                        const url = new URL(window.location);
                        url.searchParams.set('activeTab', tabName);
                        // Mengubah URL tanpa me-refresh halaman
                        window.history.pushState({}, '', url);
                    }
                }">

                <div class="w-full md:w-1/4 bg-white shadow-lg rounded-lg p-6 mb-4 md:mb-0 md:mr-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Naive Bayes Menu</h2>

                    @php
                        $menuItems = [
                            ['tab' => 'dataset', 'label' => 'Data Set', 'icon' => 'database'],
                            ['tab' => 'initial_process', 'label' => 'Initial Proses', 'icon' => 'cog'],
                            ['tab' => 'performance', 'label' => 'Performance', 'icon' => 'chart-bar'],
                            ['tab' => 'prediction', 'label' => 'Prediksi', 'icon' => 'light-bulb'],
                        ];
                    @endphp

                    <nav>
                        <ul>
                            @foreach ($menuItems as $item)
                                <li class="mb-3">
                                    {{-- KOREKSI UTAMA: Panggil updateUrl() saat tombol diklik --}}
                                    <a href="#" @click.prevent="updateUrl('{{ $item['tab'] }}')"
                                        :class="{
                                            'text-blue-600 bg-blue-50': activeTab === '{{ $item['tab'] }}',
                                            'text-gray-700': activeTab !== '{{ $item['tab'] }}'
                                        }"
                                        class="flex items-center text-lg hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition duration-200">

                                        {{-- Heroicons (outline) --}}
                                        @if ($item['icon'] === 'database')
                                            <svg class="w-6 h-6 mr-3 text-gray-500" fill="currentColor"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                            </svg>
                                        @elseif ($item['icon'] === 'cog')
                                            <svg class="w-6 h-6 mr-3 text-gray-500" fill="currentColor"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 0 1 3.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 0 0-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 0 0-4.392-4.392 49.422 49.422 0 0 0-7.436 0A4.756 4.756 0 0 0 3.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 1 0 1.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 0 1 3.01-3.01c1.19-.09 2.392-.135 3.605-.135Zm-6.97 6.22a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 0 0 4.392 4.392 49.413 49.413 0 0 0 7.436 0 4.756 4.756 0 0 0 4.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 0 0-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 0 1-3.01 3.01 47.953 47.953 0 0 1-7.21 0 3.256 3.256 0 0 1-3.01-3.01 47.759 47.759 0 0 1-.1-1.759L6.97 15.53a.75.75 0 0 0 1.06-1.06l-3-3Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @elseif ($item['icon'] === 'chart-bar')
                                            <svg class="w-6 h-6 mr-3 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3v18h18M9 17v-6m4 6V9m4 6V5" />
                                            </svg>
                                        @elseif ($item['icon'] === 'light-bulb')
                                            <svg class="w-6 h-6 mr-3 text-gray-500" fill="currentColor"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 .75a8.25 8.25 0 0 0-4.135 15.39c.686.398 1.115 1.008 1.134 1.623a.75.75 0 0 0 .577.706c.352.083.71.148 1.074.195.323.041.6-.218.6-.544v-4.661a6.714 6.714 0 0 1-.937-.171.75.75 0 1 1 .374-1.453 5.261 5.261 0 0 0 2.626 0 .75.75 0 1 1 .374 1.452 6.712 6.712 0 0 1-.937.172v4.66c0 .327.277.586.6.545.364-.047.722-.112 1.074-.195a.75.75 0 0 0 .577-.706c.02-.615.448-1.225 1.134-1.623A8.25 8.25 0 0 0 12 .75Z" />
                                                <path fill-rule="evenodd"
                                                    d="M9.013 19.9a.75.75 0 0 1 .877-.597 11.319 11.319 0 0 0 4.22 0 .75.75 0 1 1 .28 1.473 12.819 12.819 0 0 1-4.78 0 .75.75 0 0 1-.597-.876ZM9.754 22.344a.75.75 0 0 1 .824-.668 13.682 13.682 0 0 0 2.844 0 .75.75 0 1 1 .156 1.492 15.156 15.156 0 0 1-3.156 0 .75.75 0 0 1-.668-.824Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif

                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                {{-- x-cloak digunakan untuk menyembunyikan konten sebelum Alpine.js menginisialisasi --}}
                <div class="w-full md:w-3/4 bg-white shadow-lg rounded-lg p-6" x-cloak>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-4 border-b pb-4">
                        Aplikasi Klasifikasi Naive Bayes
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Selamat datang di halaman klasifikasi Naive Bayes. Pilih menu di samping kiri untuk melihat
                        detail.
                    </p>

                    {{-- KONTEN SPESIFIK --}}
                    <div class="mt-6">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
