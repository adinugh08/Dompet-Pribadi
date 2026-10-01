<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Saldo & Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-slate-800 to-indigo-900 text-white rounded-xl p-5 shadow">
                    <p class="text-sm text-slate-300">Saldo Saat Ini</p>
                    <p class="text-2xl font-bold mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white rounded-xl p-5 shadow">
                    <p class="text-sm text-gray-500">Pemasukan Bulan Ini</p>
                    <p class="text-xl font-bold text-teal-600 mt-1">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white rounded-xl p-5 shadow">
                    <p class="text-sm text-gray-500">Pengeluaran Bulan Ini</p>
                    <p class="text-xl font-bold text-red-500 mt-1">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Tombol aksi cepat --}}
            <div>
                <a href="{{ route('transaksi.create') }}"
                   class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + Catat Transaksi
                </a>
                <a href="{{ route('transaksi.index') }}"
                   class="inline-block ml-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-100">
                    Lihat Semua Transaksi
                </a>
            </div>
            {{-- Analisis AI --}}
<div class="bg-white rounded-xl shadow p-5">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-gray-800">Analisis Keuangan (AI)</h3>
        <form action="{{ route('analisis') }}" method="POST">
            @csrf
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Analisis Sekarang
            </button>
        </form>
    </div>

    @if (session('analisis_hasil'))
        <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
            {{ session('analisis_hasil') }}
        </p>
    @elseif (session('analisis_error'))
        <p class="text-sm text-red-500">{{ session('analisis_error') }}</p>
    @else
        <p class="text-sm text-gray-400">Klik tombol di atas untuk dapat analisis dari AI berdasarkan transaksi 30 hari terakhir.</p>
    @endif
</div>

{{-- Grafik --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Tren Pemasukan & Pengeluaran</h3>
        <canvas id="trendChart"></canvas>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Pengeluaran per Kategori</h3>
        <canvas id="kategoriChart"></canvas>
    </div>
</div>

            {{-- Transaksi Terbaru --}}
            <div class="bg-white rounded-xl shadow p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Transaksi Terbaru</h3>

                <div class="space-y-3">
                    @forelse ($transaksiTerbaru as $t)
                        <div class="flex justify-between items-center border-b pb-3 last:border-b-0 last:pb-0">
                            <div>
                                <p class="font-medium text-gray-700">{{ $t->kategori }}</p>
                                <p class="text-xs text-gray-400">{{ $t->tanggal->format('d M Y') }}</p>
                            </div>
                            <p class="font-semibold {{ $t->jenis === 'pemasukan' ? 'text-teal-600' : 'text-red-500' }}">
                                {{ $t->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-6">Belum ada transaksi. Yuk mulai catat!</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels),
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($trendPemasukan),
                    borderColor: '#00C2A8',
                    backgroundColor: '#00C2A8',
                    tension: 0.3,
                },
                {
                    label: 'Pengeluaran',
                    data: @json($trendPengeluaran),
                    borderColor: '#FF6B6B',
                    backgroundColor: '#FF6B6B',
                    tension: 0.3,
                }
            ]
        }
    });

    new Chart(document.getElementById('kategoriChart'), {
        type: 'doughnut',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                data: @json($kategoriTotal),
                backgroundColor: ['#FF6B6B', '#FFB020', '#00C2A8', '#8B8FD8', '#1B1F3B', '#FFD166'],
            }]
        }
    });
</script>
@endpush
</x-app-layout>