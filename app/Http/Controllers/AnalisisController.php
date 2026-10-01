<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;


class AnalisisController extends Controller
{
    public function analisis()
    {
        $userId = auth()->id();

        $transaksis = Transaksi::where('user_id', $userId)
            ->where('tanggal', '>=', now()->subDays(30))
            ->orderBy('tanggal')
            ->get();

        if ($transaksis->isEmpty()) {
            return back()->with('analisis_error', 'Belum ada cukup data transaksi untuk dianalisis. Catat beberapa transaksi dulu ya.');
        }

        $ringkasan = "Data transaksi keuangan mahasiswa 30 hari terakhir:\n\n";
        foreach ($transaksis as $t) {
            $ringkasan .= "- {$t->tanggal->format('d M')}: {$t->jenis} Rp" . number_format($t->jumlah, 0, ',', '.') . " ({$t->kategori})\n";
        }

        $totalPemasukan = $transaksis->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksis->where('jenis', 'pengeluaran')->sum('jumlah');

        $ringkasan .= "\nTotal pemasukan: Rp" . number_format($totalPemasukan, 0, ',', '.');
        $ringkasan .= "\nTotal pengeluaran: Rp" . number_format($totalPengeluaran, 0, ',', '.');

        $prompt = "Kamu adalah asisten keuangan untuk mahasiswa Indonesia. Berdasarkan data transaksi berikut, "
            . "berikan analisis singkat (maksimal 150 kata) dalam Bahasa Indonesia: "
            . "1) Apakah pola pengeluarannya tergolong boros, wajar, atau hemat, dan kenapa. "
            . "2) Satu atau dua saran praktis untuk mengelola uang lebih baik. "
            . "Gunakan bahasa yang ramah dan tidak menggurui.\n\n{$ringkasan}";

        $apiKey = config('services.gemini.api_key');

        // --- DEBUG SEMENTARA, akan kita hapus setelah ketahuan masalahnya ---
      //  dd(strlen($apiKey), substr($apiKey, 0, 5));
        // ----------------------------------------------------------------

        $response = Http::post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.8-flash:generateContent?key={$apiKey}",
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
            ]
        );

if ($response->failed()) {
    $status = $response->status();

    $pesan = match (true) {
        $status === 503 => 'Layanan AI sedang sibuk banget nih (banyak yang pakai bareng). Coba klik lagi beberapa saat ya.',
        $status === 429 => 'Jatah pemakaian gratis AI untuk hari ini sudah habis. Coba lagi besok ya.',
        $status === 400 || $status === 403 => 'Ada masalah dengan koneksi ke layanan AI. Coba hubungi developer aplikasi ini.',
        default => 'Gagal menghubungi layanan AI. Coba lagi beberapa saat lagi.',
    };

    return back()->with('analisis_error', $pesan);
}

        $hasil = $response->json('candidates.0.content.parts.0.text');

        return back()->with('analisis_hasil', $hasil);
    }
}