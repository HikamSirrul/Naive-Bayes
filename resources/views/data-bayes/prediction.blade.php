{{-- File: resources/views/naive-bayes/dataset.blade.php --}}

<h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
    {{ __('Prediksi') }}
</h2>

<div x-show="activeTab === 'prediction'">
    {{-- Form Input Prediksi --}}
    <div class="p-6 bg-blue-50 rounded-lg shadow-md border border-blue-200 mb-6">
        <h2 class="text-2xl font-semibold text-blue-800 mb-4">
            Input Data Uji untuk Prediksi
        </h2>
        <form id="prediksiForm">
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan nama siswa"
                    required>
            </div>
            <div class="mb-4">
                <label for="visual" class="block text-sm font-medium text-gray-700">Visual</label>
                <input type="number" id="visual" name="visual"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nilai visual"
                    min="0" required>
            </div>
            <div class="mb-4">
                <label for="auditori" class="block text-sm font-medium text-gray-700">Auditori</label>
                <input type="number" id="auditori" name="auditori"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nilai auditori"
                    min="0" required>
            </div>
            <div class="mb-6">
                <label for="kinestetik" class="block text-sm font-medium text-gray-700">Kinestetik</label>
                <input type="number" id="kinestetik" name="kinestetik"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nilai kinestetik"
                    min="0" required>
            </div>
            <div class="flex justify-start">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                    Prediksi
                </button>
            </div>
        </form>
    </div>

    {{-- Hasil Prediksi --}}
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-2xl font-semibold text-green-800 mb-4">
            Hasil Prediksi
        </h2>
        <div id="hasilPrediksiContainer" class="bg-white p-4 rounded">
            <p id="hasilPrediksi" class="text-black">
                -- Belum Ada Data --
            </p>
        </div>
    </div>
</div>

{{-- Script Prediksi Lokal --}}
<script>
    const form = document.getElementById('prediksiForm');
    const hasilEl = document.getElementById('hasilPrediksi');
    const hasilContainer = document.getElementById('hasilPrediksiContainer');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nama = document.getElementById('nama').value;
        const visual = parseInt(document.getElementById('visual').value);
        const auditori = parseInt(document.getElementById('auditori').value);
        const kinestetik = parseInt(document.getElementById('kinestetik').value);

        const data = {
            Visual: visual,
            Auditori: auditori,
            Kinestetik: kinestetik
        };

        const max = Math.max(...Object.values(data));
        const minat_tertinggi = Object.keys(data).filter(k => data[k] === max);
        const hasilText = `Hasil Proses menunjukkan bahwa siswa ${nama} memiliki minat belajar ${minat_tertinggi.join(' ')}.`;

        // Update hasil dan styling
        hasilEl.textContent = hasilText;
        hasilContainer.classList.remove('bg-white');
        hasilContainer.classList.add('bg-green-100', 'text-green-900', 'border-green-400');
    });
</script>

