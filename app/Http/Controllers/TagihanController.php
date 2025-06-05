<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembayarans = $user->pembayarans()
            ->with('booking')
            ->orderByDesc('created_at')
            ->get();

        $lastPaid = $pembayarans->where('midtrans_transaction_status', 'settlement')
            ->sortByDesc(fn($item) => $item->booking->tanggal_booking ?? $item->created_at)
            ->first();

        $nextMonth = null;
        if ($lastPaid && $lastPaid->booking) {
            $tanggalBooking = \Carbon\Carbon::parse($lastPaid->booking->tanggal_booking);
            $nextMonth = $tanggalBooking->addDays(30);
        }

        return view('dashboard.tagihan', compact('pembayarans', 'lastPaid', 'nextMonth'));
    }
}
