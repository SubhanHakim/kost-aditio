{{-- filepath: resources/views/filament/pages/keluhan-manajemen.blade.php --}}
<x-filament::page>
    <div class="space-y-4">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="filament-card p-0 overflow-x-auto w-full">
            <table class="w-full min-w-max divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-primary-50 dark:bg-primary-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Judul</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Pengguna</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Kamar</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($this->keluhans as $keluhan)
                        <tr @class([
                            'hover:bg-yellow-50 dark:hover:bg-yellow-900' => $keluhan->status == 'pending',
                            'hover:bg-blue-50 dark:hover:bg-blue-900' => $keluhan->status == 'proses',
                            'hover:bg-green-50 dark:hover:bg-green-900' => $keluhan->status == 'selesai',
                        ])>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $keluhan->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $keluhan->judul_keluhan }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $keluhan->deskripsi_keluhan }}</td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'inline-flex items-center px-2 py-0.5 rounded text-xs font-bold',
                                    'bg-yellow-200 text-yellow-900' => $keluhan->status == 'pending',
                                    'bg-blue-200 text-blue-900' => $keluhan->status == 'proses',
                                    'bg-green-200 text-green-900' => $keluhan->status == 'selesai',
                                ])>
                                    {{ ucfirst($keluhan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $keluhan->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $keluhan->kamar->no_kamar ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $keluhan->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <form wire:submit.prevent="updateStatus({{ $keluhan->id }}, 'pending')">
                                        <button type="submit"
                                            @class([
                                                'px-3 py-1 rounded text-xs font-bold border-2 transition shadow-sm',
                                                'bg-yellow-400 text-yellow-900 border-yellow-500 hover:bg-yellow-500' => $keluhan->status == 'pending',
                                                'bg-white text-yellow-700 border-yellow-300 hover:bg-yellow-50' => $keluhan->status != 'pending',
                                            ])>
                                            Pending
                                        </button>
                                    </form>
                                    <form wire:submit.prevent="updateStatus({{ $keluhan->id }}, 'proses')">
                                        <button type="submit"
                                            @class([
                                                'px-3 py-1 rounded text-xs font-bold border-2 transition shadow-sm',
                                                'bg-blue-400 text-blue-900 border-blue-500 hover:bg-blue-500' => $keluhan->status == 'proses',
                                                'bg-white text-blue-700 border-blue-300 hover:bg-blue-50' => $keluhan->status != 'proses',
                                            ])>
                                            Proses
                                        </button>
                                    </form>
                                    <form wire:submit.prevent="updateStatus({{ $keluhan->id }}, 'selesai')">
                                        <button type="submit"
                                            @class([
                                                'px-3 py-1 rounded text-xs font-bold border-2 transition shadow-sm',
                                                'bg-green-400 text-green-900 border-green-500 hover:bg-green-500' => $keluhan->status == 'selesai',
                                                'bg-white text-green-700 border-green-300 hover:bg-green-50' => $keluhan->status != 'selesai',
                                            ])>
                                            Selesai
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data keluhan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>