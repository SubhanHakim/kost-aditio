<x-filament-panels::page>
    <div class="space-y-4">
        <h2 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p>Ini adalah dashboard khusus untuk pengguna kost.</p>

        {{-- Contoh info tambahan --}}
        <div class="mt-4">
            <h3 class="font-semibold">Informasi Akun:</h3>
            <ul class="list-disc ml-6">
                <li>Email: {{ auth()->user()->email }}</li>
                {{-- Tambahkan info lain sesuai kebutuhan --}}
            </ul>
        </div>
    </div>
</x-filament-panels::page>
