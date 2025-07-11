{{-- File: resources/views/data-bayes/performance.blade.php --}}

<div x-show="activeTab === 'performance'" class="p-6 bg-green-50 rounded-lg shadow-md border border-green-200">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Analisis Distribusi Minat Belajar</h2>

    {{-- Filter persentase data (tanpa form submit) --}}
    <div class="mb-4">
        <label for="percentage_display" class="block text-gray-700 font-medium mb-1">Tampilkan data:</label>
        <select name="percentage_display" id="percentage_display" class="border border-gray-300 rounded-md p-2 w-40">
            @foreach ([20, 30, 40, 50, 60, 70, 80, 90] as $val)
                <option value="{{ $val }}" {{ $percentageDisplay == $val ? 'selected' : '' }}>
                    {{ $val }}%
                </option>
            @endforeach
        </select>
    </div>

    <p class="mb-2 text-gray-700">
        Menampilkan <strong id="currentPercentageDisplay">{{ ($percentageDisplay ?? 100) . '%' }}</strong> data
        (<span id="jumlahSiswaYangDitampilkan">{{ $jumlahSiswaYangDitampilkan ?? 0 }}</span> siswa).
    </p>

    {{-- Tabel hasil --}}
    <div class="overflow-x-auto mt-4 mb-6">
        <table class="min-w-full bg-white border border-gray-300 text-gray-800 text-sm">
            <thead class="bg-green-200">
                <tr>
                    <th class="px-4 py-2 border">Tipe Minat</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Persentase</th>
                </tr>
            </thead>
            <tbody id="performanceTableBody"> {{-- Tambahkan ID untuk update --}}
                <tr>
                    <td class="px-4 py-2 border text-center">Visual</td>
                    <td class="px-4 py-2 border text-center" id="jumlahVisual">{{ $jumlahVisual }}</td>
                    <td class="px-4 py-2 border text-center" id="persentaseVisual">{{ $persentaseVisual }}%</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border text-center">Auditori</td>
                    <td class="px-4 py-2 border text-center" id="jumlahAuditori">{{ $jumlahAuditori }}</td>
                    <td class="px-4 py-2 border text-center" id="persentaseAuditori">{{ $persentaseAuditori }}%</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border text-center">Kinestetik</td>
                    <td class="px-4 py-2 border text-center" id="jumlahKinestetik">{{ $jumlahKinestetik }}</td>
                    <td class="px-4 py-2 border text-center" id="persentaseKinestetik">{{ $persentaseKinestetik }}%
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border text-center">Gabungan</td>
                    <td class="px-4 py-2 border text-center" id="jumlahGabungan">{{ $jumlahGabungan }}</td>
                    <td class="px-4 py-2 border text-center" id="persentaseGabungan">{{ $persentaseGabungan }}%</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Chart --}}
    <div class="w-full sm:w-1/2 mx-auto">
        <canvas id="minatChart" class="w-full h-auto"></canvas>
    </div>

    {{-- Chart Script dan AJAX --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let minatChart;
        const percentageSelect = document.getElementById('percentage_display');
        const currentPercentageDisplayEl = document.getElementById('currentPercentageDisplay');
        const jumlahSiswaYangDitampilkanEl = document.getElementById('jumlahSiswaYangDitampilkan');

        const jumlahVisualEl = document.getElementById('jumlahVisual');
        const persentaseVisualEl = document.getElementById('persentaseVisual');
        const jumlahAuditoriEl = document.getElementById('jumlahAuditori');
        const persentaseAuditoriEl = document.getElementById('persentaseAuditori');
        const jumlahKinestetikEl = document.getElementById('jumlahKinestetik');
        const persentaseKinestetikEl = document.getElementById('persentaseKinestetik');
        const jumlahGabunganEl = document.getElementById('jumlahGabungan');
        const persentaseGabunganEl = document.getElementById('persentaseGabungan');

        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('minatChart').getContext('2d');
            minatChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Visual', 'Auditori', 'Kinestetik', 'Gabungan'],
                    datasets: [{
                        data: [
                            {{ $jumlahVisual }},
                            {{ $jumlahAuditori }},
                            {{ $jumlahKinestetik }},
                            {{ $jumlahGabungan }}
                        ],
                        backgroundColor: ['#34D399', '#60A5FA', '#FBBF24', '#F87171'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#374151'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) label += ': ';
                                    if (context.parsed !== null) {
                                        let total = context.dataset.data.reduce((sum, current) => sum +
                                            current, 0);
                                        let percentage = (context.parsed / total * 100).toFixed(2);
                                        label += context.parsed + ' (' + percentage +'%)';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });

        percentageSelect.addEventListener('change', function() {
            const selectedPercentage = this.value;
            const url = `/naive-bayes?percentage_display=${selectedPercentage}&activeTab=performance`;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // ✅ Tambahkan '%' setelah angka
                    currentPercentageDisplayEl.textContent = data.percentageDisplay +'%';
                    jumlahSiswaYangDitampilkanEl.textContent = data.jumlahSiswaYangDitampilkan;

                    jumlahVisualEl.textContent = data.jumlahVisual;
                    persentaseVisualEl.textContent = data.persentaseVisual +'%';
                    jumlahAuditoriEl.textContent = data.jumlahAuditori;
                    persentaseAuditoriEl.textContent = data.persentaseAuditori +'%';
                    jumlahKinestetikEl.textContent = data.jumlahKinestetik;
                    persentaseKinestetikEl.textContent = data.persentaseKinestetik +'%';
                    jumlahGabunganEl.textContent = data.jumlahGabungan;
                    persentaseGabunganEl.textContent = data.persentaseGabungan +'%';

                    minatChart.data.datasets[0].data = [
                        data.jumlahVisual,
                        data.jumlahAuditori,
                        data.jumlahKinestetik,
                        data.jumlahGabungan
                    ];
                    minatChart.update();
                })
                .catch(error => {
                    console.error('Error fetching performance data:', error);
                    alert('Gagal memuat data kinerja. Silakan coba lagi.');
                });
        });
    </script>

</div>
