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

    <div class="flex flex-col gap-6">
        <!-- Ringkasan Sewa - Card utama dengan highlight status -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="bg-amber-600 px-6 py-4 border-b">
                <h4 class="text-white text-lg font-bold flex items-center gap-2">
                    <i class="ti ti-home-check"></i> Informasi Kamar Anda
                </h4>
            </div>

            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri: Detail Kamar -->
                    <div>
                        <ul class="space-y-6">
                            <li class="flex items-center gap-4">
                                <i class="ti ti-door text-2xl text-amber-600 dark:text-amber-500"></i>
                                <div>
                                    <p class="text-base text-gray-900 font-medium">Nomor Kamar</p>
                                    <p class="text-lg font-semibold text-gray-700">
                                        {{ $booking->kamar->no_kamar ?? 'Belum ada' }}</p>
                                </div>
                            </li>

                            <li class="flex items-center gap-4">
                                <i class="ti ti-bed text-2xl text-amber-600 dark:text-amber-500"></i>
                                <div>
                                    <p class="text-base text-gray-900 font-medium">Tipe Kamar</p>
                                    <p class="text-lg font-semibold text-gray-700">
                                        {{ $booking->kamar->tipeKamar->nama_tipe ?? 'Belum ada' }}</p>
                                </div>
                            </li>

                            <li class="flex items-center gap-4">
                                <i class="ti ti-cash text-2xl text-amber-600 dark:text-amber-500"></i>
                                <div>
                                    <p class="text-base text-gray-900 font-medium">Tarif Bulanan</p>
                                    <p class="text-lg font-semibold text-gray-700">
                                        Rp {{ number_format($booking->kamar->tipeKamar->harga ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Kolom Kanan: Detail Tanggal -->
                    <div>
                        <ul class="space-y-6">
                            <li class="flex items-center gap-4">
                                <i class="ti ti-calendar-plus text-2xl text-amber-600 dark:text-amber-500"></i>
                                <div>
                                    <p class="text-base text-gray-900 font-medium">Tanggal Masuk</p>
                                    <p class="text-lg font-semibold text-gray-700">
                                        {{ $booking->tanggal_booking ? \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') : 'Belum ada' }}
                                    </p>
                                </div>
                            </li>

                            <li class="flex items-center gap-4">
                                <i class="ti ti-calendar-due text-2xl text-amber-600 dark:text-amber-500"></i>
                                <div>
                                    <p class="text-base text-gray-900 font-medium">Jatuh Tempo
                                        Berikutnya</p>
                                    <p class="text-lg font-semibold text-gray-700">
                                        {{ $booking->tanggal_booking ? \Carbon\Carbon::parse($booking->tanggal_booking)->addDays(30)->format('d F Y') : 'Belum ada' }}
                                    </p>
                                </div>
                            </li>

                            <li class="flex items-center gap-4">
                                <i class="ti ti-credit-card text-2xl text-amber-600 dark:text-amber-500"></i>
                                <div>
                                    <p class="text-base text-gray-900 font-medium">Status Pembayaran
                                    </p>
                                    <div class="mt-2">
                                        @if (
                                            $booking &&
                                                $booking->pembayarans &&
                                                $booking->pembayarans->where('midtrans_transaction_status', 'settlement')->count() > 0)
                                            <span
                                                class="inline-block px-4 py-2 rounded bg-green-600 text-white text-base font-bold">
                                                LUNAS
                                            </span>
                                        @else
                                            <span
                                                class="inline-block px-4 py-2 rounded bg-yellow-600 text-white text-base font-bold">
                                                BELUM LUNAS
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-wrap gap-4">
                    <a href="{{ route('dashboard.tagihan') }}"
                        class="inline-flex items-center px-6 py-3 rounded-md shadow-sm text-base font-bold text-white bg-amber-600 hover:bg-amber-700 transition-colors">
                        <i class="ti ti-receipt mr-2"></i> Lihat Tagihan
                    </a>
                    <a href="#"
                        class="inline-flex items-center px-6 py-3 rounded-md shadow-sm text-base font-bold text-gray-800 bg-gray-200 hover:bg-gray-300 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors">
                        <i class="ti ti-user mr-2"></i> Profil Saya
                    </a>
                </div>
            </div>
        </div>

        <!-- Informasi & Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pengumuman & Informasi -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="bg-amber-600 px-6 py-4 border-b">
                    <h4 class="text-white text-lg font-bold flex items-center gap-2">
                        <i class="ti ti-bell"></i> Informasi Penting
                    </h4>
                </div>

                <div class="p-6">
                    <ul class="space-y-6">
                        <li class="flex items-center gap-4">
                            <i class="ti ti-info-circle text-2xl text-blue-600 dark:text-blue-500"></i>
                            <div>
                                <p class="text-base text-gray-900 font-medium">Pembayaran Bulanan</p>
                                <p class="text-base font-semibold text-gray-700 mt-1">
                                    Mohon lakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda
                                    keterlambatan.
                                </p>
                            </div>
                        </li>

                        <li class="flex items-center gap-4">
                            <i class="ti ti-bulb text-2xl text-green-600 dark:text-green-500"></i>
                            <div>
                                <p class="text-base text-gray-900 font-medium">Hemat Listrik</p>
                                <p class="text-base font-semibold text-gray-700 mt-1">
                                    Matikan lampu dan AC saat tidak digunakan untuk menghemat energi.
                                </p>
                            </div>
                        </li>

                        <li class="flex items-center gap-4">
                            <i class="ti ti-alarm text-2xl text-red-600 dark:text-red-500"></i>
                            <div>
                                <p class="text-base text-gray-900 font-medium">Jam Malam</p>
                                <p class="text-base font-semibold text-gray-700 mt-1">
                                    Mohon jaga ketenangan setelah pukul 22.00 untuk kenyamanan bersama.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Status Sewa -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="bg-amber-600 px-6 py-4 border-b">
                    <h4 class="text-white text-lg font-bold flex items-center gap-2">
                        <i class="ti ti-calendar-stats"></i> Status Sewa Anda
                    </h4>
                </div>

                <div class="p-6">
                    <!-- Durasi Sewa -->
                    <div class="mb-8">
                        <p class="text-base text-gray-900 font-medium mb-3">Durasi Sewa</p>

                        @if ($booking && $booking->tanggal_booking)
                            @php
                                $startDate = \Carbon\Carbon::parse($booking->tanggal_booking);
                                $endDate = \Carbon\Carbon::parse($booking->tanggal_booking)->addDays(30);
                                $now = \Carbon\Carbon::now();
                                $totalDays = $startDate->diffInDays($endDate);
                                $daysLeft = $now->diffInDays($endDate, false);
                                $daysLeft = floor($daysLeft);
                                $percentage = min(100, max(0, (($totalDays - max(0, $daysLeft)) / $totalDays) * 100));
                            @endphp

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-base font-semibold text-gray-700">
                                    {{ $daysLeft > 0 ? "$daysLeft hari tersisa" : 'Masa sewa habis' }}
                                </span>
                                <span class="text-base font-semibold text-gray-700">
                                    {{ number_format($percentage, 0) }}%
                                </span>
                            </div>

                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-lg h-3">
                                <div class="bg-amber-600 h-3 rounded-lg" style="width: {{ $percentage }}%"></div>
                            </div>

                            <div class="mt-2 flex justify-between text-base text-gray-700">
                                <span>{{ $startDate->format('d M Y') }}</span>
                                <span>{{ $endDate->format('d M Y') }}</span>
                            </div>
                        @else
                            <p class="text-lg font-semibold text-gray-700 italic">
                                Belum ada informasi sewa
                            </p>
                        @endif
                    </div>

                    <!-- Riwayat Pembayaran Ringkas -->
                    <div>
                        <p class="text-base text-gray-900 font-medium mb-3">Riwayat Pembayaran Terakhir</p>

                        @if ($booking && $booking->pembayarans && $booking->pembayarans->count() > 0)
                            <div class="space-y-4">
                                @foreach ($booking->pembayarans->sortByDesc('created_at')->take(3) as $pembayaran)
                                    <div
                                        class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div class="flex items-center gap-4">
                                            @if ($pembayaran->midtrans_transaction_status === 'settlement')
                                                <i
                                                    class="ti ti-circle-check text-2xl text-green-600 dark:text-green-500"></i>
                                            @else
                                                <i
                                                    class="ti ti-alert-circle text-2xl text-yellow-600 dark:text-yellow-500"></i>
                                            @endif
                                            <div>
                                                <p class="text-base text-gray-900 font-medium">
                                                    {{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d F Y') }}
                                                </p>
                                                <p class="text-base font-semibold text-gray-700">
                                                    @if ($pembayaran->midtrans_transaction_status === 'settlement')
                                                        Lunas
                                                    @else
                                                        Menunggu Pembayaran
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-base font-semibold text-gray-700">
                                                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 text-center">
                                <a href="{{ route('dashboard.tagihan') }}"
                                    class="inline-flex items-center px-6 py-3 rounded-md shadow-sm text-base font-bold text-white bg-amber-600 hover:bg-amber-700 transition-colors">
                                    Lihat Semua Riwayat <i class="ti ti-arrow-right ml-2"></i>
                                </a>
                            </div>
                        @else
                            <p class="text-lg font-semibold text-gray-700 italic">
                                Belum ada riwayat pembayaran
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
