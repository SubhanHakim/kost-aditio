<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua pembayaran user (beserta relasi booking)
        $pembayarans = $user->pembayarans()
            ->with('booking')
            ->orderByDesc('created_at')
            ->get();

        // Filter: HANYA tampilkan pembayaran yang BELUM LUNAS dan
        // BELUM ADA settlement untuk kamar & tanggal booking yang sama
        $filtered = $pembayarans->filter(function ($pembayaran) use ($pembayarans) {
            if ($pembayaran->midtrans_transaction_status === 'settlement') {
                return true;
            }
            // Cek apakah ada settlement untuk kamar & tanggal booking yang sama
            $sudahLunas = $pembayarans->contains(function ($other) use ($pembayaran) {
                return $other->midtrans_transaction_status === 'settlement'
                    && $other->booking
                    && $pembayaran->booking
                    && $other->booking->kamar_id == $pembayaran->booking->kamar_id
                    && $other->booking->tanggal_booking == $pembayaran->booking->tanggal_booking;
            });
            return !$sudahLunas;
        })->values();

        $lastPaid = $filtered->where('midtrans_transaction_status', 'settlement')
            ->sortByDesc(fn($item) => $item->booking->tanggal_booking ?? $item->created_at)
            ->first();

        $nextMonth = null;
        if ($lastPaid && $lastPaid->booking) {
            $tanggalBooking = \Carbon\Carbon::parse($lastPaid->booking->tanggal_booking);
            $nextMonth = $tanggalBooking->addDays(30);
        }

        return view('dashboard.tagihan', [
            'pembayarans' => $filtered,
            'lastPaid' => $lastPaid,
            'nextMonth' => $nextMonth,
        ]);
    }
}
