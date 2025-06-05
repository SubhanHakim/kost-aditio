{{-- filepath: resources/views/dashboard/testimoni.blade.php --}}
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
        <h2 class="text-xl font-semibold mb-6 text-[#1e1e1e] dark:text-[#1e1e1e]">Testimoni</h2>
        <div class="space-y-6">
            <!-- Contoh testimoni statis, ganti dengan loop jika ada data dinamis -->
            <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <span class="font-semibold text-[#1e1e1e] dark:text-gray-100">Budi</span>
                    <span class="text-xs text-gray-400">Mei 2025</span>
                </div>
                <p class="text-[#1e1e1e] dark:text-gray-200">
                    Kostnya nyaman, fasilitas lengkap, dan pemilik ramah!
                </p>
            </div>
            <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <span class="font-semibold text-[#1e1e1e] dark:text-gray-100">Siti</span>
                    <span class="text-xs text-gray-400">April 2025</span>
                </div>
                <p class="text-[#1e1e1e] dark:text-gray-200">
                    Lokasi strategis, harga terjangkau. Recommended!
                </p>
            </div>
            <!-- Tambahkan testimoni lain di sini -->
        </div>
    </div>
</x-app-layout>