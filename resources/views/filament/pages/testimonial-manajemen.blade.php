{{-- filepath: resources/views/filament/pages/testimonial-manajemen.blade.php --}}
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
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">User</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Pesan</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Rating</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-bold text-primary-700 dark:text-primary-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($this->testimonials as $testimonial)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $testimonial->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $testimonial->pesan }}</td>
                            <td class="px-4 py-3 text-sm text-yellow-500 dark:text-yellow-400">
                                {!! $testimonial->rating_stars !!}
                            </td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'inline-flex items-center px-2 py-0.5 rounded text-xs font-bold',
                                    'bg-yellow-200 text-yellow-900' => $testimonial->status == 'pending',
                                    'bg-green-200 text-green-900' => $testimonial->status == 'approved',
                                    'bg-red-200 text-red-900' => $testimonial->status == 'rejected',
                                ])>
                                    {{ ucfirst($testimonial->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <form wire:submit.prevent="updateStatus({{ $testimonial->id }}, 'pending')">
                                        <button type="submit"
                                            @class([
                                                'px-3 py-1 rounded text-xs font-bold border-2 transition shadow-sm',
                                                'bg-yellow-400 text-yellow-900 border-yellow-500 hover:bg-yellow-500' => $testimonial->status == 'pending',
                                                'bg-white text-yellow-700 border-yellow-300 hover:bg-yellow-50' => $testimonial->status != 'pending',
                                            ])>
                                            Pending
                                        </button>
                                    </form>
                                    <form wire:submit.prevent="updateStatus({{ $testimonial->id }}, 'approved')">
                                        <button type="submit"
                                            @class([
                                                'px-3 py-1 rounded text-xs font-bold border-2 transition shadow-sm',
                                                'bg-green-400 text-green-900 border-green-500 hover:bg-green-500' => $testimonial->status == 'approved',
                                                'bg-white text-green-700 border-green-300 hover:bg-green-50' => $testimonial->status != 'approved',
                                            ])>
                                            Approve
                                        </button>
                                    </form>
                                    <form wire:submit.prevent="updateStatus({{ $testimonial->id }}, 'rejected')">
                                        <button type="submit"
                                            @class([
                                                'px-3 py-1 rounded text-xs font-bold border-2 transition shadow-sm',
                                                'bg-red-400 text-red-900 border-red-500 hover:bg-red-500' => $testimonial->status == 'rejected',
                                                'bg-white text-red-700 border-red-300 hover:bg-red-50' => $testimonial->status != 'rejected',
                                            ])>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data testimonial.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament::page>