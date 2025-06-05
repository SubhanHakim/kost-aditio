<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $fillable = [
        'nama_fasilitas',
        'image',
    ];

    /**
     * Get the kamar that has this fasilitas.
     */
    public function kamars()
    {
        return $this->belongsToMany(Kamar::class, 'kamar_fasilitas');
    }
}
