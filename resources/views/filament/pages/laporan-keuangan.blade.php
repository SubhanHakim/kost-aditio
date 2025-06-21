<x-filament::page>
    <x-filament::card>
        <form wire:submit="submit">
            <div class="space-y-6">
                {{ $this->form }}

                <div class="pt-3 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-filament::button type="submit">
                        Tampilkan Laporan
                    </x-filament::button>
                </div>
            </div>
        </form>
    </x-filament::card>

    @if (isset($this->data['start_date']))
        @php
            $financialData = $this->getFinancialData();
        @endphp

        <x-filament::card class="mt-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold tracking-tight">
                    Laporan Keuangan: {{ $financialData['start_date'] }} - {{ $financialData['end_date'] }}
                </h2>

                <div class="flex items-center gap-3">
                    <x-filament::button color="gray" icon="heroicon-m-printer" onclick="window.print()">
                        Cetak
                    </x-filament::button>

                    <x-filament::button color="success" icon="heroicon-m-arrow-down-tray" wire:click="downloadExcel">
                        Download Excel
                    </x-filament::button>
                </div>
            </div>

            <!-- Statistik Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <h3 class="text-base font-medium text-gray-500 dark:text-gray-400 truncate">
                        Total Pendapatan
                    </h3>
                    <p class="text-3xl font-semibold mt-1 dark:text-white">
                        Rp {{ number_format($financialData['total'], 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <h3 class="text-base font-medium text-gray-500 dark:text-gray-400 truncate">
                        Jumlah Transaksi
                    </h3>
                    <p class="text-3xl font-semibold mt-1 dark:text-white">
                        {{ $financialData['count'] }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <h3 class="text-base font-medium text-gray-500 dark:text-gray-400 truncate">
                        Rata-rata per Transaksi
                    </h3>
                    <p class="text-3xl font-semibold mt-1 dark:text-white">
                        @if ($financialData['count'] > 0)
                            Rp {{ number_format($financialData['total'] / $financialData['count'], 0, ',', '.') }}
                        @else
                            Rp 0
                        @endif
                    </p>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="mt-8">
                <h3 class="text-lg font-medium mb-4">
                    Daftar Transaksi
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                <th scope="col" class="px-6 py-3">Pengguna</th>
                                <th scope="col" class="px-6 py-3">Kamar</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($financialData['transactions'] as $transaction)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $transaction->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction->booking->kamar->no_kamar ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if ($transaction->status === 'paid') bg-green-100 text-green-800 
                                            @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ match ($transaction->status) {
                                                'paid' => 'Sudah Dibayar',
                                                'pending' => 'Menunggu Pembayaran',
                                                'failed' => 'Gagal',
                                                default => ucfirst($transaction->status),
                                            } }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium">
                                        Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="6" class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm text-gray-500">
                                                Tidak ada data transaksi pada periode ini
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            @if (count($financialData['transactions']) > 0)
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <td colspan="5"
                                        class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                        Total:
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($financialData['total'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </x-filament::card>
    @endif

    <!-- Styling untuk cetak laporan -->
    <style>
        @media print {

            .filament-header,
            .filament-sidebar,
            .filament-topbar,
            .filament-main-footer,
            button,
            [wire\:click],
            [onclick],
            form,
            .filament-button {
                display: none !important;
            }

            .filament-main-content {
                padding: 0 !important;
                margin: 0 !important;
            }

            .filament-card {
                box-shadow: none !important;
                margin-bottom: 2rem !important;
            }

            @page {
                margin: 1cm;
            }
        }
    </style>
</x-filament::page>
