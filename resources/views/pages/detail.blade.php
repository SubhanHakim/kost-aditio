{{-- filepath: resources/views/pages/detail.blade.php --}}
@extends('welcome')
@section('title', 'Detail Kamar')

@section('content')

    <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 bg-white rounded-full shadow-md flex items-center justify-center">
            <a href="/"><i class="ti ti-arrow-left text-teal-500 text-3xl"></i></a>
        </div>
        <div>
            <h2 class="text-base md:text-lg font-semibold"><a href="/">Home</a> /
                <span>{{ $tipeKamar->nama_tipe }}</span>
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        {{-- Gambar utama --}}
        <div>
            <img src="{{ isset($tipeKamar->image[0]) ? asset('storage/' . $tipeKamar->image[0]) : asset('images/default.png') }}"
                alt="{{ $tipeKamar->nama_tipe ?? '-' }}" class="w-full h-[520px] object-cover rounded-lg shadow">
            {{-- Informasi kamar --}}
            <div class="mt-6">
                <h2 class="text-2xl font-bold text-[#263238] mb-2">{{ $tipeKamar->nama_tipe ?? '-' }}</h2>
                <div class="mb-2 text-gray-600">{{ $tipeKamar->deskripsi ?? '-' }}</div>
                <div class="mb-4">
                    <div class="font-semibold mb-1">Fasilitas:</div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php
                            $firstKamar = $kamars->first();
                        @endphp
                        @if ($firstKamar && $firstKamar->fasilitas)
                            @foreach ($firstKamar->fasilitas as $fasilitas)
                                <div class="flex items-center gap-2 mb-2">
                                    <img src="{{ asset('storage/' . $fasilitas->image) }}"
                                        alt="{{ $fasilitas->nama_fasilitas }}" class="w-8 h-8 object-contain rounded">
                                    <span
                                        class="text-base text-[#263238] font-medium">{{ $fasilitas->nama_fasilitas }}</span>
                                </div>
                            @endforeach
                        @else
                            <span class="text-gray-400">Tidak ada fasilitas</span>
                        @endif
                    </div>
                </div>
                <div class="mb-4 text-lg font-bold text-[#DC8330]">
                    Rp {{ number_format($tipeKamar->harga ?? 0, 0, ',', '.') }} / bulan
                </div>
            </div>
        </div>
        {{-- Dua gambar kecil di kanan --}}
        <div class="flex flex-col gap-4">
            <div class="">
                <img src="{{ isset($tipeKamar->image[1]) ? asset('storage/' . $tipeKamar->image[1]) : asset('images/default.png') }}"
                    alt="Gambar 2" class="w-full h-[259px] object-cover rounded-lg shadow">
            </div>
            <div class="">
                <img src="{{ isset($tipeKamar->image[2]) ? asset('storage/' . $tipeKamar->image[2]) : asset('images/default.png') }}"
                    alt="Gambar 3" class="w-full h-[259px] object-cover rounded-lg shadow">
            </div>
            {{-- Form Booking --}}
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Form Booking</h3>
                @auth
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full border rounded px-3 py-2"
                                value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Tipe Kamar</label>
                            <input type="text" class="w-full border rounded px-3 py-2" value="{{ $tipeKamar->nama_tipe }}"
                                readonly>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">No Kamar</label>
                            <select name="kamar_id" class="w-full border rounded px-3 py-2" required>
                                <option value="">-- Pilih No Kamar --</option>
                                @foreach ($kamars as $kamarItem)
                                    <option value="{{ $kamarItem->id }}">{{ $kamarItem->no_kamar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Nomor HP</label>
                            <input type="text" name="no_hp" class="w-full border rounded px-3 py-2"
                                value="{{ Auth::user()->no_hp ?? '' }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Tanggal Booking</label>
                            <input type="date" name="tanggal_booking" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#DC8330] text-white py-2 rounded hover:bg-[#b96a23] transition">
                            Booking Sekarang
                        </button>
                    </form>
                @else
                    <div class="text-center text-red-500 font-semibold mt-4">
                        Silakan <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> untuk melakukan
                        booking.
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
