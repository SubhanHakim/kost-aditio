<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $booking = $user->bookings()
            ->whereHas('pembayaran', function ($q) {
                $q->where('midtrans_transaction_status', 'settlement');
            })
            ->latest('tanggal_booking')
            ->with(['kamar.tipeKamar'])
            ->first();

        return view('dashboard.home', compact('booking'));
    }

    public function index()
    {
        $user = Auth::user();

        // Ambil semua pembayaran user, urutkan terbaru
        $pembayarans = $user->pembayarans()
            ->with('booking')
            ->orderByDesc('created_at')
            ->get();

        // Cari pembayaran terakhir yang statusnya settlement (lunas di Midtrans)
        $lastPaid = $pembayarans->where('midtrans_transaction_status', 'settlement')
            ->sortByDesc(fn($item) => $item->booking->tanggal_booking ?? $item->created_at)
            ->first();

        $nextMonth = null;
        if ($lastPaid && $lastPaid->booking) {
            $tanggalBooking = \Carbon\Carbon::parse($lastPaid->booking->tanggal_booking);
            $nextMonth = $tanggalBooking->addMonthNoOverflow(); // Lebih tepat untuk bulan berikutnya
        }

        $sudahLunas = $pembayarans->where('midtrans_transaction_status', 'settlement')->isNotEmpty();

        return view('dashboard.tagihan', compact('pembayarans', 'lastPaid', 'nextMonth', 'sudahLunas'));
    }
}
