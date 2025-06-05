<div class="p-4 text-center">
    <h1 class="text-3xl uppercase font-semibold">Kost Aditio</h1>
</div>
<div class="scroll-sidebar" data-simplebar="">
    <nav class=" w-full flex flex-col sidebar-nav px-4 mt-5">
        <ul id="sidebarnav" class="text-gray-600 text-sm">
            <li class="text-xs font-bold pb-[5px]">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">HOME</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard">
                    <i class="ti ti-layout-dashboard ps-2 text-2xl"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">PEMBAYARAN</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/tagihan*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/tagihan">
                    <i class="ti ti-credit-card ps-2 text-2xl"></i> <span>Tagihan Bulanan</span>
                </a>
            </li>

            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">MASUKAN DAN SARAN</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/testimoni*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/testimoni">
                    <i class="ti ti-message ps-2 text-2xl"></i> <span>Testimoni</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
        {{ request()->is('dashboard/keluhan') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }}"
                    href="/dashboard/keluhan">
                    <i class="ti ti-mail-opened ps-2 text-2xl"></i> <span>Keluhan</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
