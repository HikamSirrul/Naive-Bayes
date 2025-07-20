<div x-data="{ activeTab: localStorage.getItem('activeTab') || 'dataset' }" x-init="$watch('activeTab', val => localStorage.setItem('activeTab', val))">

    <div x-show="activeTab === 'dataset'">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Set') }}
            </h2>
        </x-slot>

        <div class="p-6 bg-gray-50 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Halaman DataSet</h2>
            <p class="text-gray-700 mb-4">Pastikan format file adalah `.xlsx` atau `.xls`.</p>

            <!-- ALERT -->
            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-400 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 rounded-md bg-red-100 border border-red-400 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <!-- UPLOAD FORM -->
            <form action="{{ route('naive.bayes.upload_excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="excel_file" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Excel:</label>
                    <input type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls" class="block w-full text-sm file:py-2 file:px-4 file:bg-blue-50 file:text-blue-700" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Unggah Data</button>
            </form>

            <!-- HAPUS SEMUA DATA -->
            @if (isset($allData) && $allData->isNotEmpty())
                <form action="{{ route('naive.bayes.delete_all') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua data?')" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Hapus Semua Data</button>
                </form>
            @endif

            <!-- TABEL PREVIEW -->
            <div class="mt-8 bg-white p-4 rounded-md border">
                <p class="font-semibold text-gray-800">Preview DataSet:</p>
                @if (isset($allData) && $allData->isNotEmpty())
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200 text-center">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 border">Nama</th>
                                    <th class="p-2 border">Jenis Kelamin</th>
                                    <th class="p-2 border">Kelas</th>
                                    <th class="p-2 border">Hasil Visual</th>
                                    <th class="p-2 border">Hasil Audiotori</th>
                                    <th class="p-2 border">Hasil Kinestik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-2 border">{{ $data->nama }}</td>
                                        <td class="p-2 border">{{ $data->jenis_kelamin }}</td>
                                        <td class="p-2 border">{{ $data->kelas }}</td>
                                        <td class="p-2 border">{{ $data->hasil_visual }}</td>
                                        <td class="p-2 border">{{ $data->hasil_auditori }}</td>
                                        <td class="p-2 border">{{ $data->hasil_kinestetik }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-red-500 mt-2">Belum ada data yang diunggah.</p>
                @endif
            </div>
        </div>
    </div>
</div>
