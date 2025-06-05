<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="bg-[#FDFDFC] font-sans antialiased min-h-screen flex flex-col">
    @include('partials.header')
    <main class="flex-1 px-[100px] py-8 bg-[#FDFDFC]">
        <div class="w-full">
            @yield('content')
        </div>
        @yield('hero-image')
        @yield('after-hero')
    </main>

    @include('partials.footer')

    @if (session('error'))
        <div x-data="{ open: true }" x-show="open"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                <div class="text-red-600 text-xl font-bold mb-2">Peringatan</div>
                <div class="mb-4">{{ session('error') }}</div>
                <button @click="open = false"
                    class="px-4 py-2 bg-[#DC8330] text-white rounded hover:bg-[#b96a23] transition">
                    Tutup
                </button>
            </div>
        </div>
    @endif
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
