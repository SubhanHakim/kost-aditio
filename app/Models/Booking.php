<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'kamar_id',
        'tanggal_booking',
        'status_booking',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    
}
