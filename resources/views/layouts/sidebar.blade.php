{{-- filepath: resources/views/layouts/sidebar.blade.php --}}
<div class="p-4 text-center">
    <h1 class="text-3xl uppercase font-semibold">Kost Aditio</h1>
</div>
<div class="scroll-sidebar" data-simplebar="">
    <nav class="w-full flex flex-col sidebar-nav px-4 mt-5">
        <ul id="sidebarnav" class="text-gray-600 text-sm">
            <li class="text-xs font-bold pb-[5px]">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">HOME</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
                {{ request()->is('dashboard') ? 'bg-amber-100 text-amber-700' : 'text-gray-500' }} 
                hover:!bg-gray-100 hover:!text-amber-600"
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
                {{ request()->is('dashboard/tagihan*') ? 'bg-amber-100 text-amber-700' : 'text-gray-500' }}
                hover:!bg-gray-100 hover:!text-amber-600"
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
                {{ request()->is('dashboard/testimoni*') ? 'bg-amber-100 text-amber-700' : 'text-gray-500' }}
                hover:!bg-gray-100 hover:!text-amber-600"
                    href="/dashboard/testimoni">
                    <i class="ti ti-message ps-2 text-2xl"></i> <span>Testimoni</span>
                </a>
            </li>
            
            <li class="sidebar-item">
                <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full
                {{ request()->is('dashboard/keluhan') ? 'bg-amber-100 text-amber-700' : 'text-gray-500' }}
                hover:!bg-gray-100 hover:!text-amber-600"
                    href="/dashboard/keluhan">
                    <i class="ti ti-mail-opened ps-2 text-2xl"></i> <span>Keluhan</span>
                </a>
            </li>
            
            <li class="text-xs font-bold mb-4 mt-6">
                <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center"></i>
                <span class="text-xs text-gray-400 font-semibold">AKUN</span>
            </li>
            
            <li class="sidebar-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center relative rounded-md w-full text-gray-500 hover:!bg-red-100 hover:!text-red-600">
                        <i class="ti ti-logout ps-2 text-2xl"></i> <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>

<style>
.sidebar-link:hover {
    background-color: #f3f4f6 !important;
    color: #d97706 !important;
}

form .sidebar-link:hover {
    background-color: #fee2e2 !important;
    color: #dc2626 !important;
}
</style>