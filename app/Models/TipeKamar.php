<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model
{
    protected $fillable = [
        'nama_tipe',
        'deskripsi',
        'harga',
        'total_kamar',
        'image'
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function kamars()
{
    return $this->hasMany(Kamar::class, 'tipe_kamar_id');
}
}
