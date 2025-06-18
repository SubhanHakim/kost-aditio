<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Dashboard\KeluhanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home']);

Route::get('/dashboard', [DashboardController::class, 'home'])
    ->middleware(['auth', 'verified', 'role:user', 'must.be.paid'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard/tagihan', [TagihanController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:user', 'must.be.paid'])
    ->name('dashboard.tagihan');

Route::get('/dashboard/testimoni', function () {
    return view('dashboard.testimoni');
})->middleware(['auth', 'verified', 'role:user', 'must.be.paid'])->name('dashboard.testimoni');

Route::middleware(['auth', 'verified', 'role:user', 'must.be.paid'])->group(function () {
    Route::get('/dashboard/keluhan', [KeluhanController::class, 'index'])->name('dashboard.keluhan');
    Route::post('/dashboard/keluhan', [KeluhanController::class, 'store'])->name('dashboard.keluhan.store');
});

Route::middleware(['auth', 'verified', 'role:user', 'must.be.paid'])->group(function () {
    Route::get('/dashboard/testimoni', [TestimonialController::class, 'index'])->name('dashboard.testimoni');
    Route::post('/dashboard/testimoni', [TestimonialController::class, 'store'])->name('dashboard.testimoni.store');
});


Route::get('/detail-kamar/{kamar}', [KamarController::class, 'show'])
    ->name('detail.kamar');

Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('booking.store');

Route::get('/midtrans/pay/{snap_token}', function ($snap_token) {
    return view('midtrans.pay', compact('snap_token'));
})->name('midtrans.pay');


require __DIR__ . '/auth.php';
