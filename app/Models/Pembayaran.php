<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'jumlah',
        'midtrans_snap_token',
        'midtrans_order_id',
        'midtrans_transaction_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
