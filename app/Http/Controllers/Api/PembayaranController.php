<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function webhook(Request $request)
    {
        $notif = $request->all();
        $orderId = $notif['order_id'] ?? null;
        $transactionStatus = $notif['transaction_status'] ?? null;

        Log::info('Midtrans Webhook Received', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'data' => $notif
        ]);

        $bookingId = null;
        if ($orderId && preg_match('/BOOKING-(\d+)-/', $orderId, $matches)) {
            $bookingId = $matches[1];
        }

        $pembayaran = Pembayaran::where('booking_id', $bookingId)->first();
        if ($pembayaran) {
            
            $pembayaran->midtrans_transaction_status = $transactionStatus;
            
            
            switch ($transactionStatus) {
                case 'pending':
                    $pembayaran->status = 'pending'; 
                    break;
                case 'capture':
                case 'settlement':
                    $pembayaran->status = 'paid';
                    $pembayaran->tanggal_verifikasi = now();
                    break;
                case 'deny':
                case 'expire':
                case 'cancel':
                    $pembayaran->status = 'failed';
                    break;
                case 'refund':
                case 'partial_refund':
                    $pembayaran->status = 'refunded';
                    break;
                default:
                    $pembayaran->status = 'processing';
            }
            
            $pembayaran->save();
            
            Log::info('Pembayaran status updated', [
                'booking_id' => $bookingId,
                'status' => $pembayaran->status,
                'midtrans_status' => $transactionStatus
            ]);

          
            if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
                $booking = $pembayaran->booking;
                if ($booking) {
                    $booking->status_booking = 'confirmed';
                    $booking->save();

                    if ($booking->kamar) {
                        $booking->kamar->status = 'ditempati';
                        $booking->kamar->save();
                        
                        Log::info('Kamar status updated to ditempati', [
                            'kamar_id' => $booking->kamar->id,
                            'no_kamar' => $booking->kamar->no_kamar
                        ]);
                    }
                }
            }
        } else {
            Log::warning('Pembayaran tidak ditemukan untuk booking ID: ' . $bookingId);
        }

        return response()->json(['success' => true]);
    }
}