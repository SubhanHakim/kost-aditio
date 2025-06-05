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

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-6 text-[#1e1e1e] dark:text-[#1e1e1e]">Keluhan</h2>

        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <form class="space-y-4 max-w-xl" method="POST" action="{{ route('dashboard.keluhan.store') }}">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Judul Keluhan</label>
                <input type="text" name="judul" class="w-full rounded-md border-gray-300" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Isi Keluhan</label>
                <textarea name="isi" rows="4" class="w-full rounded-md border-gray-300" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">No Kamar</label>
                <select name="kamar_id" class="w-full rounded-md border-gray-300" required>
                    <option value="">Pilih Kamar</option>
                    @foreach ($kamars as $kamar)
                        <option value="{{ $kamar->id }}">{{ $kamar->no_kamar }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="px-5 py-2 rounded-md bg-blue-600 text-white font-semibold hover:bg-blue-700">Kirim
                Keluhan</button>
        </form>

        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-4">Daftar Keluhan Anda</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Judul</th>
                    <th class="px-4 py-2 text-left">Isi</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keluhans as $keluhan)
                    <tr>
                        <td class="px-4 py-2">{{ $keluhan->judul_keluhan }}</td>
                        <td class="px-4 py-2">{{ $keluhan->deskripsi_keluhan }}</td>
                        <td class="px-4 py-2">
                            @if ($keluhan->status === 'pending')
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">Belum
                                    Diproses</span>
                            @elseif($keluhan->status === 'proses')
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">Diproses</span>
                            @else
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Selesai</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $keluhan->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-400">Belum ada keluhan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
