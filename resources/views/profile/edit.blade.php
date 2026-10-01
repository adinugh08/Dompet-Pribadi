<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ editMode: false }">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Tampilan info (default) --}}
            <div x-show="!editMode" class="bg-white shadow rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-2xl font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-4 text-sm border-t pt-4">
                    <div>
                        <dt class="text-gray-400">Bergabung sejak</dt>
                        <dd class="font-medium text-gray-700">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-400">Status Email</dt>
                        <dd class="font-medium text-gray-700">
                            {{ auth()->user()->email_verified_at ? 'Terverifikasi' : 'Belum diverifikasi' }}
                        </dd>
                    </div>
                </dl>

                <button @click="editMode = true"
                        class="mt-6 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    Edit Profil
                </button>
            </div>

            {{-- Form edit (muncul setelah klik tombol) --}}
            <div x-show="editMode" x-cloak class="space-y-6">
                <button @click="editMode = false"
                        class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                    ← Kembali ke info profil
                </button>

                <div class="bg-white p-6 shadow rounded-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="bg-white p-6 shadow rounded-xl">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="bg-white p-6 shadow rounded-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>