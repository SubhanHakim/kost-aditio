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

    <div class="">
        @include('dashboard.home')
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    @endpush
</x-app-layout>
