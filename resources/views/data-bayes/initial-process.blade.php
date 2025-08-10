<div x-show="activeTab === 'initial_process'"
    class="p-6 bg-yellow-50 rounded-lg shadow-md border border-yellow-200">

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">
        Halaman Initial Proses.
    </h2>

    @if (isset($allData) && $allData->isNotEmpty())
        <div class="overflow-x-auto bg-white rounded-md border border-gray-300 p-4">
            <table class="min-w-full table-auto border-collapse text-sm text-center">
                <thead>
                    <tr class="bg-gray-100 text-gray-800">
                        <th colspan="5" class="border border-gray-300 px-2 py-2">Label Target</th>
                        <th colspan="1" class="border border-gray-300 px-2 py-2">Atribut Pendukung</th>
                    </tr>
                    <tr class="bg-gray-200 text-gray-900">
                        <th class="border border-gray-300 px-2 py-1">Nama Siswa</th>
                        <th class="border border-gray-300 px-2 py-1">Jenis Kelamin</th>
                        <th class="border border-gray-300 px-2 py-1">Visual</th>
                        <th class="border border-gray-300 px-2 py-1">Auditori</th>
                        <th class="border border-gray-300 px-2 py-1">Kinestetik</th>
                        <th class="border border-gray-300 px-2 py-1">Minat Belajar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allData as $siswa)
                        <tr class="hover:bg-yellow-50 cursor-default">
                            <td class="border border-gray-300 px-2 py-1">{{ $siswa->nama }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $siswa->jenis_kelamin }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $siswa->hasil_visual }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $siswa->hasil_auditori }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $siswa->hasil_kinestetik }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ $siswa->akhir }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-red-600 font-semibold mt-4">
            Belum ada data yang tersedia. Silakan unggah dataset terlebih dahulu.
        </p>
        {{-- Update Minor Bug --}}
    @endif
</div>
