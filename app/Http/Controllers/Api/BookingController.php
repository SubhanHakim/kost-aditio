<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kamar;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class BookingController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'kamar_id' => 'required|exists:kamars,id',
        'tanggal_booking' => 'required|date',
    ]);

    // Cek apakah user sudah punya pembayaran settlement untuk kamar & tanggal booking yang sama
    $sudahLunasBulanIni = Pembayaran::where('user_id', $request->user()->id)
        ->whereHas('booking', function ($q) use ($request) {
            $q->where('kamar_id', $request->kamar_id)
              ->whereDate('tanggal_booking', $request->tanggal_booking);
        })
        ->where('midtrans_transaction_status', 'settlement')
        ->exists();

    if ($sudahLunasBulanIni) {
        return back()->with('error', 'Tagihan bulan ini sudah lunas.');
    }

    $kamar = Kamar::find($request->kamar_id);

    if (!$kamar) {
        return back()->with('error', 'Kamar tidak ditemukan.');
    }

    // Tambahkan kode berikut sebelum membuat booking baru:
    Pembayaran::where('user_id', $request->user()->id)
        ->where('midtrans_transaction_status', 'pending')
        ->whereHas('booking', function ($q) use ($request) {
            $q->where('kamar_id', $request->kamar_id)
              ->whereDate('tanggal_booking', $request->tanggal_booking);
        })
        ->update(['midtrans_transaction_status' => 'canceled']);

    // Buat booking baru untuk bulan berikutnya
    $booking = Booking::create([
        'user_id' => $request->user()->id,
        'kamar_id' => $request->kamar_id,
        'tanggal_booking' => $request->tanggal_booking,
        'status_booking' => 'pending',
    ]);

    // Midtrans config
    MidtransConfig::$serverKey = config('midtrans.server_key');
    MidtransConfig::$isProduction = config('midtrans.is_production');
    MidtransConfig::$isSanitized = true;
    MidtransConfig::$is3ds = true;

    $orderId = 'BOOKING-' . $booking->id . '-' . time();
    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => (int) $booking->kamar->tipeKamar->harga,
        ],
        'customer_details' => [
            'email' => $request->user()->email,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    Pembayaran::create([
        'user_id' => $request->user()->id,
        'booking_id' => $booking->id,
        'jumlah' => $booking->kamar->tipeKamar->harga,
        'midtrans_snap_token' => $snapToken,
        'midtrans_order_id' => $orderId,
        'midtrans_transaction_status' => 'pending',
    ]);

    return redirect()->route('midtrans.pay', ['snap_token' => $snapToken]);
}
}
