{{-- File: resources/views/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="flex flex-col font-semibold text-xl text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full bg-white shadow-lg rounded-lg p-6 mt-4 md:mt-0">

            {{-- Judul utama ----------------------------------------------------- --}}
            <div class="p-6 bg-white border-b border-gray-200">
                <h1
                    class="mt-8 text-2xl sm:text-3xl font-extrabold text-gray-900 text-center break-words max-w-screen-md mx-auto px-4">
                    PENERAPAN DATA MINING UNTUK MENGKLASIFIKASIKAN MINAT BELAJAR SISWA BERDASARKAN
                    GAYA BELAJAR VISUAL, AUDITORI, KINESTETIK DI SDN 228 CANGKUANG
                    DENGAN METODE NAIVE BAYES CLASSIFIER
                </h1>
            </div>


            {{-- Ringkasan progres ------------------------------------------------ --}}
            <div class="mb-8 p-6 bg-blue-50 rounded-md shadow-sm">
                <h2 class="text-2xl font-semibold text-blue-800 mb-4">
                    Ringkasan Progres
                </h2>

                <div
                    class="w-full bg-green-100 p-4 rounded-md flex flex-col items-center justify-center text-center mb-6">
                    <p class="text-4xl font-bold">{{ $jumlahSiswa }}</p>
                    <p class="text-lg text-green-600 mt-2">Jumlah Siswa</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-100 p-4 rounded-md flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-bold text-blue-700">{{ $jumlahVisual }}</p>
                        <p class="text-lg text-blue-600 mt-2">Visual</p>
                    </div>

                    <div class="bg-green-100 p-4 rounded-md flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-bold text-green-700">{{ $jumlahAuditori }}</p>
                        <p class="text-lg text-green-600 mt-2">Auditori</p>
                    </div>

                    <div class="bg-purple-100 p-4 rounded-md flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-bold text-purple-700">{{ $jumlahKinestetik }}</p>
                        <p class="text-lg text-purple-600 mt-2">Kinestetik</p>
                    </div>
                </div>
            </div>

            {{-- Grafik pie: hanya tampil jika ada data ------------------------- --}}
            @if ($jumlahVisual + $jumlahAuditori + $jumlahKinestetik > 0)
                <div class="p-6 bg-white rounded-md shadow-sm border border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">
                        Distribusi Gaya Belajar
                    </h2>
                    <div class="flex justify-center">
                        <div class="w-full max-w-sm md:max-w-md lg:max-w-lg aspect-square">
                            <canvas id="gayaBelajarChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-6 bg-white rounded-md shadow-sm border border-gray-200 text-center">
                    <p class="text-lg text-gray-500">
                        Tidak Ada Data.
                    </p>
                </div>
            @endif

        </div>
    </div>

    {{-- Script Chart.js ------------------------------------------------------ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('gayaBelajarChart');
            if (!canvas) return; // tidak ada canvas (data kosong)

            const visual = {{ $jumlahVisual }};
            const auditori = {{ $jumlahAuditori }};
            const kinestetik = {{ $jumlahKinestetik }};

            const total = visual + auditori + kinestetik;
            if (total === 0) return; // keamanan ekstra

            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Visual', 'Auditori', 'Kinestetik'],
                    datasets: [{
                        data: [visual, auditori, kinestetik],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.6)',
                            'rgba(16, 185, 129, 0.6)',
                            'rgba(139, 92, 246, 0.6)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(139, 92, 246, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Distribusi Gaya Belajar Siswa'
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
