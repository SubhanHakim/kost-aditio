{{-- filepath: resources/views/dashboard/keluhan.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class="w-full flex items-center justify-between" aria-label="Global">
            <ul class="icon-nav flex items-center gap-4">
                <li class="relative xl:hidden">
                    <a class="text-xl icon-hover cursor-pointer text-heading" id="headerCollapse"
                        data-hs-overlay="#application-sidebar-brand" aria-controls="application-sidebar-brand"
                        aria-label="Toggle navigation" href="javascript:void(0)">
                        <i class="ti ti-menu-2 relative z-1"></i>
                    </a>
                </li>
                <li class="relative">
                    @include('header-components.dd-notification')
                </li>
            </ul>
            <div class="flex items-center gap-4">
                @include('header-components.dd-profile')
            </div>
        </nav>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="bg-amber-600 px-6 py-4">
            <h4 class="text-white text-lg font-bold">Keluhan Anda</h4>
        </div>

        <div class="p-6">
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-100 text-green-800 font-medium rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Keluhan -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-black mb-4">Sampaikan Keluhan</h3>
                
                <form method="POST" action="{{ route('dashboard.keluhan.store') }}" class="space-y-5 max-w-xl">
                    @csrf
                    <div>
                        <label class="block text-base font-medium text-black dark:text-white mb-2">Judul Keluhan</label>
                        <input type="text" name="judul" class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 text-base" 
                            placeholder="Contoh: Keran air bocor" required>
                    </div>
                    
                    <div>
                        <label class="block text-base font-medium text-black dark:text-white mb-2">Isi Keluhan</label>
                        <textarea name="isi" rows="4" class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 text-base" 
                            placeholder="Jelaskan detail masalah Anda di sini..." required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-base font-medium text-black dark:text-white mb-2">No Kamar</label>
                        <select name="kamar_id" class="w-full p-3 rounded-md border border-gray-300 dark:border-gray-600 text-base" required>
                            <option value="">Pilih Kamar</option>
                            @foreach ($kamars as $kamar)
                                <option value="{{ $kamar->id }}">{{ $kamar->no_kamar }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="px-6 py-3 bg-amber-600 text-white font-bold rounded-md hover:bg-amber-700">
                        Kirim Keluhan
                    </button>
                </form>
            </div>

            <div class="border-t border-gray-300 dark:border-gray-600 pt-6">
                <h3 class="text-lg font-bold text-black dark:text-white mb-4">Riwayat Keluhan</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                <th class="py-3 px-4 text-left text-base font-bold text-black">Judul</th>
                                <th class="py-3 px-4 text-left text-base font-bold text-black">Keluhan</th>
                                <th class="py-3 px-4 text-left text-base font-bold text-black">Status</th>
                                <th class="py-3 px-4 text-left text-base font-bold text-black">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keluhans as $keluhan)
                                <tr class="border-b border-gray-300 dark:border-gray-600">
                                    <td class="py-4 px-4 text-base font-medium text-black">
                                        {{ $keluhan->judul_keluhan }}
                                    </td>
                                    <td class="py-4 px-4 text-base text-black">
                                        {{ $keluhan->deskripsi_keluhan }}
                                    </td>
                                    <td class="py-4 px-4">
                                        @if ($keluhan->status === 'pending')
                                            <span class="py-1 px-3 bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 font-bold rounded">Menunggu</span>
                                        @elseif($keluhan->status === 'proses')
                                            <span class="py-1 px-3 bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 font-bold rounded">Diproses</span>
                                        @else
                                            <span class="py-1 px-3 bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 font-bold rounded">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-base text-black">
                                        {{ $keluhan->created_at->format('d-m-Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-base text-gray-500 dark:text-gray-400 italic">
                                        Belum ada keluhan yang diajukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>