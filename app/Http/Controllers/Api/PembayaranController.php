<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function webhook(Request $request)
    {
        $notif = $request->all();
        $orderId = $notif['order_id'] ?? null;
        $transactionStatus = $notif['transaction_status'] ?? null;

        // Ambil booking_id dari order_id, contoh: BOOKING-12-1717234567
        $bookingId = null;
        if ($orderId && preg_match('/BOOKING-(\d+)-/', $orderId, $matches)) {
            $bookingId = $matches[1];
        }

        $pembayaran = Pembayaran::where('booking_id', $bookingId)->first();
        if ($pembayaran) {
            // Update status transaksi dari Midtrans
            $pembayaran->midtrans_transaction_status = $transactionStatus;
            $pembayaran->save();

            // Jika pembayaran sukses (settlement), update booking & kamar
            if ($transactionStatus === 'settlement') {
                $pembayaran->booking->status_booking = 'confirmed';
                $pembayaran->booking->save();

                $booking = $pembayaran->booking;
                if ($booking && $booking->kamar) {
                    $booking->kamar->status = 'ditempati';
                    $booking->kamar->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }
}