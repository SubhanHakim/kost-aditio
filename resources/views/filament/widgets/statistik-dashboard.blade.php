{{-- filepath: resources/views/filament/widgets/statistik-dashboard.blade.php --}}
<x-filament::widget>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-gray-500">Jumlah Kamar</div>
            <div class="text-2xl font-bold">{{ $jumlahKamar }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-gray-500">Jumlah Pendapatan</div>
            <div class="text-2xl font-bold">Rp {{ number_format($jumlahPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <div class="text-gray-500">Jumlah Penyewa Sudah Bayar</div>
            <div class="text-2xl font-bold">{{ $jumlahPenyewaSudahBayar }}</div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded shadow p-4">
            <div class="font-bold mb-2">List Sudah Bayar</div>
            <ul>
                @foreach($listSudahBayar as $user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white rounded shadow p-4">
            <div class="font-bold mb-2">List Belum Bayar</div>
            <ul>
                @foreach($listBelumBayar as $user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-filament::widget>