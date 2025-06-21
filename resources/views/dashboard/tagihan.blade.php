{{-- filepath: resources/views/dashboard/tagihan.blade.php --}}
<x-app-layout>
    <x-slot name="header">
    <nav class="w-full flex items-center justify-between py-2" aria-label="Global">
        <!-- Left Side -->
        <div class="flex items-center gap-4">
            <!-- Mobile Toggle Menu -->
            <div class="relative xl:hidden">
                <a class="text-xl icon-hover cursor-pointer text-heading p-2 rounded-md hover:bg-gray-100"
                    id="headerCollapse" data-hs-overlay="#application-sidebar-brand"
                    aria-controls="application-sidebar-brand" aria-label="Toggle navigation"
                    href="javascript:void(0)">
                    <i class="ti ti-menu-2 relative z-1"></i>
                </a>
            </div>

            <!-- Page Title and Breadcrumb -->
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $title ?? 'Tagihan Bulanan' }}</h1>
                <div class="text-sm text-gray-500 flex items-center">
                    <a href="/dashboard" class="hover:text-amber-600">Home</a>
                    <span class="mx-2">/</span>
                    <a href="/dashboard/tagihan" class="hover:text-amber-600">Tagihan</a>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-4">
            <!-- Profile Dropdown -->
            @include('header-components.dd-profile')
        </div>
    </nav>
</x-slot>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="bg-amber-600 px-6 py-4">
            <h4 class="text-white text-lg font-bold">Tagihan Bulanan</h4>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="py-3 px-4 text-left text-base font-bold text-gray-900">Bulan</th>
                            <th class="py-3 px-4 text-left text-base font-bold text-gray-900">Jumlah</th>
                            <th class="py-3 px-4 text-left text-base font-bold text-gray-900">Status</th>
                            <th class="py-3 px-4 text-left text-base font-bold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="py-4 px-4 text-base text-gray-900">
                                    {{ $pembayaran->booking && $pembayaran->booking->tanggal_booking
                                        ? \Carbon\Carbon::parse($pembayaran->booking->tanggal_booking)->translatedFormat('F Y')
                                        : '-' }}
                                </td>
                                <td class="py-4 px-4 text-base font-medium text-gray-900">
                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4">
                                    @if ($pembayaran->midtrans_transaction_status === 'settlement')
                                        <span class="text-green-600 dark:text-green-500 font-medium">LUNAS</span>
                                    @else
                                        <span class="text-yellow-600 dark:text-yellow-500 font-medium">BELUM LUNAS</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if ($pembayaran->midtrans_transaction_status !== 'settlement')
                                        <form action="{{ route('booking.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="kamar_id" value="{{ $pembayaran->booking->kamar_id }}">
                                            <input type="hidden" name="tanggal_booking" value="{{ $pembayaran->booking->tanggal_booking }}">
                                            <button type="submit" class="px-4 py-2 bg-amber-600 text-white font-medium rounded hover:bg-amber-700">
                                                Bayar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        {{-- Tagihan bulan berikutnya --}}
                        @if ($nextMonth && !$pembayarans->where('booking.tanggal_booking', $nextMonth->format('Y-m-d'))->count())
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="py-4 px-4 text-base text-gray-900">
                                    {{ $nextMonth->translatedFormat('F Y') }} 
                                    <span class="ml-2 text-blue-600 dark:text-blue-400 text-sm">(Bulan depan)</span>
                                </td>
                                <td class="py-4 px-4 text-base font-medium text-gray-900">
                                    Rp {{ number_format($lastPaid->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-blue-600 dark:text-blue-400 font-medium">BELUM TERSEDIA</span>
                                </td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('booking.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kamar_id" value="{{ $lastPaid->booking->kamar_id }}">
                                        <input type="hidden" name="tanggal_booking" value="{{ $nextMonth->format('Y-m-d') }}">
                                        <button type="submit" class="px-4 py-2 bg-amber-600 text-white font-medium rounded hover:bg-amber-700">
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
    </div>
</x-app-layout>