{{-- filepath: resources/views/dashboard/tagihan.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <nav class=" w-ful flex items-center justify-between" aria-label="Global">
            <ul class="icon-nav flex items-center gap-4">
                <li class="relative xl:hidden">
                    <a class="text-xl  icon-hover cursor-pointer text-heading" id="headerCollapse"
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
        <h2 class="text-xl font-semibold mb-6 text-[#1e1e1e] dark:text-[#1e1e1e]">Tagihan Bulanan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-3 text-left text-xs font-semibold ...">Bulan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold ...">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold ...">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold ...">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($pembayarans as $pembayaran)
                        <tr>
                            <td class="px-4 py-3">
                                {{ $pembayaran->booking && $pembayaran->booking->tanggal_booking
                                    ? \Carbon\Carbon::parse($pembayaran->booking->tanggal_booking)->translatedFormat('F Y')
                                    : '-' }}
                            </td>
                            <td class="px-4 py-3">
                                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($pembayaran->midtrans_transaction_status === 'settlement')
                                    <span
                                        class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Lunas</span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Belum
                                        Lunas</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($pembayaran->midtrans_transaction_status !== 'settlement')
                                    <form action="{{ route('booking.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kamar_id"
                                            value="{{ $pembayaran->booking->kamar_id }}">
                                        <input type="hidden" name="tanggal_booking"
                                            value="{{ $pembayaran->booking->tanggal_booking }}">
                                        <button type="submit"
                                            class="px-3 py-1 rounded bg-blue-600 text-white text-xs hover:bg-blue-700">
                                            Bayar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    {{-- Tagihan bulan berikutnya --}}
                    @if ($nextMonth && !$pembayarans->where('booking.tanggal_booking', $nextMonth->format('Y-m-d'))->count())
                        <tr>
                            <td class="px-4 py-3">{{ $nextMonth->translatedFormat('F Y') }}</td>
                            <td class="px-4 py-3">
                                Rp {{ number_format($lastPaid->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Belum
                                    Lunas</span>
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('booking.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kamar_id" value="{{ $lastPaid->booking->kamar_id }}">
                                    <input type="hidden" name="tanggal_booking"
                                        value="{{ $nextMonth->format('Y-m-d') }}">
                                    <button type="submit"
                                        class="px-3 py-1 rounded bg-blue-600 text-white text-xs hover:bg-blue-700">
                                        Bayar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
