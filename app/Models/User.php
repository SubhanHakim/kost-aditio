<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'user_id');
    }
    public function keluhans()
    {
        return $this->hasMany(\App\Models\Keluhan::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function approvedTestimonials()
    {
        return $this->hasMany(Testimonial::class)->where('status', 'approved');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class)->latest();
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
