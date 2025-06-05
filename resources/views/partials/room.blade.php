{{-- filepath: resources/views/partials/room.blade.php --}}
<div class="py-[100px]">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
        @foreach ($tipeKamars as $tipeKamar)
            <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                <img src="{{ isset($tipeKamar->image[0]) ? asset('storage/' . $tipeKamar->image[0]) : asset('images/default.png') }}"
                    class="w-full h-48 object-cover" alt="{{ $tipeKamar->nama_tipe ?? '-' }}">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xl font-semibold text-[#263238]">{{ $tipeKamar->nama_tipe ?? '-' }}</h3>
                        <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            {{ $tipeKamar->kamars->where('status', 'tersedia')->count() }} kamar tersedia
                        </span>
                    </div>
                    <ul class="text-gray-600 text-sm mb-4 space-y-1">
                        <li>Total Kamar: {{ $tipeKamar->total_kamar }}</li>
                    </ul>
                    <div class="mt-auto flex items-center justify-between gap-2">
                        <div class="text-lg font-bold text-[#DC8330]">
                            Rp {{ number_format($tipeKamar->harga ?? 0, 0, ',', '.') }} / bulan
                        </div>
                        <a href="{{ route('detail.kamar', $tipeKamar->id) }}"
                            class="px-5 py-2 bg-[#DC8330] text-white rounded hover:bg-[#b96a23] transition whitespace-nowrap">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>