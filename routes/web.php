<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Models\Transaksi;
use App\Http\Controllers\AnalisisController;

Route::post('/analisis', [AnalisisController::class, 'analisis'])->name('analisis');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $userId = auth()->id();

    $totalPemasukan = Transaksi::where('user_id', $userId)
        ->where('jenis', 'pemasukan')->sum('jumlah');

    $totalPengeluaran = Transaksi::where('user_id', $userId)
        ->where('jenis', 'pengeluaran')->sum('jumlah');

    $saldo = $totalPemasukan - $totalPengeluaran;

    $pemasukanBulanIni = Transaksi::where('user_id', $userId)
        ->where('jenis', 'pemasukan')
        ->whereYear('tanggal', now()->year)
        ->whereMonth('tanggal', now()->month)
        ->sum('jumlah');

    $pengeluaranBulanIni = Transaksi::where('user_id', $userId)
        ->where('jenis', 'pengeluaran')
        ->whereYear('tanggal', now()->year)
        ->whereMonth('tanggal', now()->month)
        ->sum('jumlah');

    $transaksiTerbaru = Transaksi::where('user_id', $userId)
        ->orderBy('tanggal', 'desc')
        ->take(5)
        ->get();

        // Data untuk grafik tren 6 bulan terakhir
$trendLabels = [];
$trendPemasukan = [];
$trendPengeluaran = [];

for ($i = 5; $i >= 0; $i--) {
    $bulan = now()->subMonths($i);
    $trendLabels[] = $bulan->translatedFormat('M Y');

    $trendPemasukan[] = Transaksi::where('user_id', $userId)
        ->where('jenis', 'pemasukan')
        ->whereYear('tanggal', $bulan->year)
        ->whereMonth('tanggal', $bulan->month)
        ->sum('jumlah');

    $trendPengeluaran[] = Transaksi::where('user_id', $userId)
        ->where('jenis', 'pengeluaran')
        ->whereYear('tanggal', $bulan->year)
        ->whereMonth('tanggal', $bulan->month)
        ->sum('jumlah');
}

// Data untuk grafik breakdown kategori pengeluaran (semua waktu)
$kategoriData = Transaksi::where('user_id', $userId)
    ->where('jenis', 'pengeluaran')
    ->selectRaw('kategori, SUM(jumlah) as total')
    ->groupBy('kategori')
    ->orderByDesc('total')
    ->get();

$kategoriLabels = $kategoriData->pluck('kategori');
$kategoriTotal = $kategoriData->pluck('total');

    return view('dashboard', compact(
    'saldo', 'pemasukanBulanIni', 'pengeluaranBulanIni', 'transaksiTerbaru',
    'trendLabels', 'trendPemasukan', 'trendPengeluaran',
    'kategoriLabels', 'kategoriTotal'
));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/analisis', [AnalisisController::class, 'analisis'])->name('analisis');
});

require __DIR__.'/auth.php';