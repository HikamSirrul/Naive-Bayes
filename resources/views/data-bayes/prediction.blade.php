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
            <div class="mb-4 relative"> {{-- Tambahkan class "relative" --}}
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan nama siswa"
                    autocomplete="off" required>
                <ul id="autocomplete-list"
                    class="absolute left-0 right-0 z-10 bg-white border border-gray-300 mt-1 rounded-md hidden shadow-md max-h-48 overflow-y-auto">
                </ul>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <input type="text" id="jenis_kelamin" name="jenis_kelamin"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    placeholder="Masukkan jenis kelamin siswa L/P" required>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" id="kelas" name="kelas"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan kelas siswa"
                    required>
            </div>
            <div class="mb-4">
                <label for="visual" class="block text-sm font-medium text-gray-700">Visual</label>
                <input type="number" id="visual" name="visual"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nilai visual"
                    min="0" max="5" required>
            </div>
            <div class="mb-4">
                <label for="auditori" class="block text-sm font-medium text-gray-700">Auditori</label>
                <input type="number" id="auditori" name="auditori"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nilai auditori"
                    min="0" max="5" required>
            </div>
            <div class="mb-6">
                <label for="kinestetik" class="block text-sm font-medium text-gray-700">Kinestetik</label>
                <input type="number" id="kinestetik" name="kinestetik"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Nilai kinestetik"
                    min="0" max="5" required>
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
document.addEventListener('DOMContentLoaded', function () {
    const namaInput = document.getElementById('nama');
    const list = document.getElementById('autocomplete-list');

    let debounce;
    namaInput.addEventListener('input', function () {
        clearTimeout(debounce);
        const query = this.value.trim();
        if (query.length < 2) {
            list.innerHTML = '';
            list.classList.add('hidden');
            return;
        }

        debounce = setTimeout(() => {
            fetch(`/api/search-siswa?term=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    list.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(nama => {
                            const li = document.createElement('li');
                            li.textContent = nama;
                            li.classList.add('px-3', 'py-2', 'hover:bg-blue-100', 'cursor-pointer');
                            li.addEventListener('mousedown', function (e) {
                                e.preventDefault(); // cegah blur
                                namaInput.value = nama;
                                list.innerHTML = '';
                                list.classList.add('hidden');
                                fetchDataSiswa(nama);
                            });
                            list.appendChild(li);
                        });
                        list.classList.remove('hidden');
                    } else {
                        list.classList.add('hidden');
                    }
                });
        }, 200); // debounce agar tidak spam request
    });

    document.addEventListener('click', function (e) {
        if (!namaInput.contains(e.target) && !list.contains(e.target)) {
            list.classList.add('hidden');
        }
    });

    function fetchDataSiswa(nama) {
        fetch(`/api/get-siswa?nama=${encodeURIComponent(nama)}`)
            .then(res => {
                if (!res.ok) throw new Error('Tidak ditemukan');
                return res.json();
            })
            .then(data => {
                document.getElementById('jenis_kelamin').value = data.jenis_kelamin || '';
                document.getElementById('kelas').value = data.kelas || '';
                document.getElementById('visual').value = data.visual ?? '';
                document.getElementById('auditori').value = data.auditori ?? '';
                document.getElementById('kinestetik').value = data.kinestetik ?? '';
            })
            .catch(() => {
                document.getElementById('jenis_kelamin').value = '';
                document.getElementById('kelas').value = '';
                document.getElementById('visual').value = '';
                document.getElementById('auditori').value = '';
                document.getElementById('kinestetik').value = '';
            });
    }

    // Prediksi logic
    const form = document.getElementById('prediksiForm');
    const hasilEl = document.getElementById('hasilPrediksi');
    const hasilContainer = document.getElementById('hasilPrediksiContainer');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const nama = namaInput.value.trim();
        const visual = parseFloat(document.getElementById('visual').value);
        const auditori = parseFloat(document.getElementById('auditori').value);
        const kinestetik = parseFloat(document.getElementById('kinestetik').value);

        const valid = [visual, auditori, kinestetik].every(n => !isNaN(n) && n >= 0 && n <= 5);

        if (!valid) {
            alert('Semua nilai VAK harus diisi dengan angka antara 0 sampai 5.');
            return;
        }

        const data = { Visual: visual, Auditori: auditori, Kinestetik: kinestetik };
        const max = Math.max(...Object.values(data));
        const minat_tertinggi = Object.keys(data).filter(k => data[k] === max);

        hasilEl.innerHTML = `
            Hasil proses menunjukkan bahwa siswa <strong>${nama}</strong> memiliki minat belajar:
            <strong>${minat_tertinggi.join(', ')}</strong>.
        `;
        hasilContainer.className = 'bg-green-100 text-green-900 border border-green-400 p-4 rounded';
    });
});
</script>

