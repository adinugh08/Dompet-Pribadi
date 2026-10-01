<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title>Dompet Kuliah — Kelola Keuangan Kuliahmu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F7FB] text-[#151A33]">

    <!-- Navbar -->
    <nav class="bg-[#1B1F3B]">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#1B1F3B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2v-1.5M21 7.5h-5a2.25 2.25 0 000 4.5h5v-4.5z" />
                    </svg>
                </div>
                <span class="text-white font-semibold tracking-tight">Dompet Kuliah</span>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 px-4 py-2 rounded-lg">Ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 px-4 py-2 rounded-lg">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="bg-[#1B1F3B] pb-24 pt-12 sm:pt-20">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block text-xs font-semibold tracking-wide text-teal-300 bg-teal-400/10 px-3 py-1 rounded-full mb-5">
                    DIBUAT KHUSUS UNTUK MAHASISWA
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight">
                    Kelola Uang Kuliahmu<br>
                    <span class="text-teal-400">Tanpa Pusing.</span>
                </h1>
                <p class="mt-5 text-slate-300 text-lg max-w-md">
                    Catat pemasukan & pengeluaran, pantau saldo, dan dapatkan analisis keuangan otomatis dari AI — biar uang bulananmu lebih terkontrol.
                </p>
                <div class="mt-8 flex gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-teal-500 hover:bg-teal-400 text-[#1B1F3B] font-semibold px-6 py-3 rounded-xl">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="bg-teal-500 hover:bg-teal-400 text-[#1B1F3B] font-semibold px-6 py-3 rounded-xl">Mulai Sekarang</a>
                        <a href="{{ route('login') }}" class="text-white font-medium px-6 py-3 rounded-xl border border-white/20 hover:bg-white/5">Saya sudah punya akun</a>
                    @endauth
                </div>
            </div>

            <!-- Ilustrasi (SVG inline) -->
            <div class="relative hidden lg:block">
                <svg viewBox="0 0 420 340" class="w-full">
                    <defs>
                        <linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#00C2A8"/>
                            <stop offset="100%" stop-color="#00897a"/>
                        </linearGradient>
                    </defs>
                    <circle cx="210" cy="170" r="150" fill="#242A52"/>
                    <rect x="70" y="120" width="230" height="140" rx="16" fill="url(#g1)"/>
                    <rect x="70" y="120" width="230" height="36" rx="16" fill="#00897a"/>
                    <circle cx="260" cy="190" r="22" fill="#FFD166"/>
                    <rect x="100" y="200" width="100" height="10" rx="5" fill="rgba(255,255,255,.5)"/>
                    <rect x="100" y="222" width="70" height="10" rx="5" fill="rgba(255,255,255,.3)"/>
                    <rect x="150" y="60" width="150" height="90" rx="12" fill="#2E2F6E"/>
                    <polyline points="165,125 195,95 215,110 250,70 280,90" fill="none" stroke="#00C2A8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="280" cy="90" r="5" fill="#00C2A8"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section class="max-w-7xl mx-auto px-6 -mt-14">
        <div class="grid sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-6-6h12"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800">Catat Transaksi</h3>
                <p class="text-sm text-gray-500 mt-1">Tambah pemasukan & pengeluaran dalam hitungan detik, dari HP atau laptop.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l7 7-7 7zm0-13L4 13l5 6"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800">Analisis AI</h3>
                <p class="text-sm text-gray-500 mt-1">Dapat masukan otomatis: apakah pengeluaranmu boros, wajar, atau sudah hemat.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l4-4 4 4 4-6"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800">Grafik & Laporan</h3>
                <p class="text-sm text-gray-500 mt-1">Lihat tren bulanan dan sebaran kategori pengeluaran secara visual.</p>
            </div>
        </div>
    </section>

    <footer class="text-center text-sm text-gray-400 py-10 mt-10">
        &copy; {{ date('Y') }} Dompet Kuliah — dibuat oleh Adi
    </footer>

</body>
</html>