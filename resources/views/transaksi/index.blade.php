<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('transaksi.create') }}"
                   class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + Catat Transaksi
                </a>
            </div>

            <div class="hidden md:block bg-white shadow rounded-lg overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Catatan</th>
                            <th class="px-4 py-3 text-right">Jumlah</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $t)
                            <tr class="border-t">
                                <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ $t->kategori }}</td>
                                <td class="px-4 py-3">{{ $t->catatan ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-semibold whitespace-nowrap {{ $t->jenis === 'pemasukan' ? 'text-teal-600' : 'text-red-500' }}">
                                    {{ $t->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('transaksi.edit', $t) }}" class="text-blue-600">Edit</a>
                                    <form action="{{ route('transaksi.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Yakin mau hapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-3">
                @forelse ($transaksis as $t)
                    <div class="bg-white shadow rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">{{ $t->kategori }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</p>
                            </div>
                            <p class="font-semibold {{ $t->jenis === 'pemasukan' ? 'text-teal-600' : 'text-red-500' }}">
                                {{ $t->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                            </p>
                        </div>
                        @if ($t->catatan)
                            <p class="text-sm text-gray-500 mt-2">{{ $t->catatan }}</p>
                        @endif
                        <div class="flex gap-3 mt-3 text-sm">
                            <a href="{{ route('transaksi.edit', $t) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('transaksi.destroy', $t) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 py-6">Belum ada transaksi.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>