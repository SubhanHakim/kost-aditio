<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'tipe_kamar_id',
        'no_kamar',
        'status',
    ];

    public function tipeKamar()
    {
        return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id');
    }
    public function keluhans()
    {
        return $this->hasMany(Keluhan::class, 'kamar_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'kamar_fasilitas');
    }
}
