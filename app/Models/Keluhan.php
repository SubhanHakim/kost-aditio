<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $fillable = [
        'user_id',
        'kamar_id',
        'judul_keluhan',
        'deskripsi_keluhan',
        'status',
    ];

    /**
     * Get the kamar that has this keluhan.
     */
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
