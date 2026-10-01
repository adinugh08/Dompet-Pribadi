<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dompet Kuliah') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen grid lg:grid-cols-2">

        <!-- Panel kiri: branding (disembunyikan di HP) -->
        <div class="hidden lg:flex flex-col justify-between bg-[#1B1F3B] p-12 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-72 h-72 rounded-full bg-teal-400/10"></div>
            <div class="absolute -left-10 bottom-10 w-56 h-56 rounded-full bg-indigo-500/10"></div>

            <a href="/" class="flex items-center gap-2.5 relative z-10">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#1B1F3B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2v-1.5M21 7.5h-5a2.25 2.25 0 000 4.5h5v-4.5z" />
                    </svg>
                </div>
                <span class="text-white font-semibold tracking-tight">Dompet Kuliah</span>
            </a>

            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-white leading-snug">
                    Satu tempat buat<br>semua catatan keuanganmu.
                </h2>
                <p class="text-slate-400 mt-3 max-w-sm">
                    Pemasukan, pengeluaran, dan analisis AI — semua dalam satu dashboard yang rapi.
                </p>
            </div>

            <p class="relative z-10 text-xs text-slate-500">&copy; {{ date('Y') }} Dompet Kuliah</p>
        </div>

        <!-- Panel kanan: form -->
        <div class="flex flex-col justify-center items-center bg-[#F5F7FB] px-6 py-12">
            <div class="w-full max-w-sm">
                <!-- Logo, cuma tampil di HP -->
                <div class="flex lg:hidden items-center gap-2.5 justify-center mb-8">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#1B1F3B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2v-1.5M21 7.5h-5a2.25 2.25 0 000 4.5h5v-4.5z" />
                        </svg>
                    </div>
                    <span class="text-[#1B1F3B] font-semibold tracking-tight">Dompet Kuliah</span>
                </div>

                <div class="bg-white shadow-lg rounded-2xl p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>