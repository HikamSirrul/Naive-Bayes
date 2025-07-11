    <div class="flex flex-col md:flex-row min-h-screen">
        <div class="w-full md:w-1/4 bg-white shadow-lg rounded-lg p-6 mb-4 md:mb-0 md:mr-6">
            <h2 class="flex flex-col font-semibold text-xl text-gray-800">
                Menu Dashboard
            </h2>
            <nav>
                <ul>
                    <li class="mb-3">
                        <a href="#"
                            class="flex items-center text-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25a2.25 2.25 0 0 1-2.25 2.25h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75A2.25 2.25 0 0 1 15.75 13.5H18a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                            </svg>
                            Ringkasan
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#"
                            class="flex items-center text-lg text-gray-700 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 21l-3.279-3.279A3.375 3.375 0 0 1 6.382 15H5.25a2.25 2.25 0 0 1-2.25-2.25V10.5a2.25 2.25 0 0 1 2.25-2.25h5.372c.504-.006 1.009.017 1.506.072z" />
                            </svg>
                            Data Skripsi
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#"
                            class="flex items-center text-lg text-gray-700 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25H21M7.5 10.5h6" />
                            </svg>
                            Laporan
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#"
                            class="flex items-center text-lg text-gray-700 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-md transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 18H7.5m3-6h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 12H7.5" />
                            </svg>
                            Pengaturan
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Bagian Main Content (Konten Utama Kanan) -->
        <!-- Mengembalikan lebar w-3/4 untuk desktop, w-full untuk mobile -->
        <div class="w-full md:w-3/4 bg-white shadow-lg rounded-lg p-6 mt-4 md:mt-0">
            <!-- Header Konten Utama yang Disesuaikan dari Input Anda -->
            <div class="p-6 bg-white border-b border-gray-200">
                {{-- Jika Anda memiliki komponen logo Jetstream, bisa ditambahkan di sini: --}}
                {{-- <x-application-logo class="block h-12 w-auto" /> --}}

                <h1 class="mt-8 text-3xl font-extrabold text-gray-900">
                    Skripsi Aldi
                </h1>

                <p class="mt-6 text-gray-500 leading-relaxed">
                    Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel
                    is designed
                    to help you build your application using a development environment that is simple, powerful, and
                    enjoyable. We believe
                    you should love expressing your creativity through programming, so we have spent time carefully crafting
                    the Laravel
                    ecosystem to be a breath of fresh air. We hope you love it.
                </p>
            </div>
            <!-- Akhir Header Konten Utama yang Disesuaikan -->

            <!-- Bagian Ringkasan / Statistik -->
            <div class="mb-8 p-6 bg-blue-50 rounded-md shadow-sm">
                <h2 class="text-2xl font-semibold text-blue-800 mb-4">
                    Ringkasan Progres
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-100 p-4 rounded-md flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-bold text-blue-700">80%</p>
                        <p class="text-lg text-blue-600 mt-2">Bab Selesai</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-md flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-bold text-green-700">5</p>
                        <p class="text-lg text-green-600 mt-2">Pertemuan Bimbingan</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-md flex flex-col items-center justify-center text-center">
                        <p class="text-4xl font-bold text-purple-700">12</p>
                        <p class="text-lg text-purple-600 mt-2">Catatan Penelitian</p>
                    </div>
                </div>
            </div>

            <!-- Bagian Aktivitas Terbaru -->
            <div class="p-6 bg-white rounded-md shadow-sm border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                    Aktivitas Terbaru
                </h2>
                <ul class="list-disc list-inside text-gray-700">
                    <li class="mb-2">Bab 3 telah direvisi pada 5 Juni 2025.</li>
                    <li class="mb-2">Pertemuan bimbingan dijadwalkan pada 10 Juni 2025.</li>
                    <li>Menambahkan 3 referensi baru ke daftar pustaka.</li>
                </ul>
            </div>

        </div>

    </div>
