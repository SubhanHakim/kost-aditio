<header class="w-full px-[100px] py-[30px] shadow-md border-b border-gray-200 bg-white">
    @if (Route::has('login'))
        <nav class="w-full flex items-center justify-between gap-4">
            <!-- Logo -->
            <div>
                <h2 class="font-bold text-lg tracking-wide">
                    <a href="/" class="hover:text-primary">ADITIO</a>
                </h2>
            </div>
            <!-- Menu -->
            <div class="flex gap-6">
                <a href="/" class="hover:underline">Beranda</a>
                <a href="#fasilitas" class="hover:underline">About</a>
                <a href="#kontak" class="hover:underline">Booking</a>
                <a href="#kontak" class="hover:underline">Testimonial</a>
            </div>
            <!-- Auth -->
            <div class="flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#263238] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Dashboard
                    </a>

                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button type="submit"
                            class="inline-block px-5 py-1.5 bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 rounded-sm text-sm leading-normal transition"
                            @click.prevent="$root.submit();">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#263238] text-[#1b1b18] border border-transparent hover:bg-gray-100 dark:hover:bg-gray-200 hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 bg-[#19140035] dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] border-[#19140035] hover:bg-[#1915014a] dark:hover:bg-[#62605b] border rounded-sm text-sm leading-normal transition">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    @endif
</header>
