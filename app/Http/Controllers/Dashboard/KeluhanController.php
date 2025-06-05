<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluhanController extends Controller
{
    public function index()
{
    $kamars = Auth::user()->bookings()->with('kamar')->get()->pluck('kamar')->unique('id');
    $keluhans = Auth::user()->keluhans()->latest()->get();
    return view('dashboard.keluhan', compact('kamars', 'keluhans'));
}

public function store(Request $request)
{
    $request->validate([
        'kamar_id' => 'required|exists:kamars,id',
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
    ]);

    Keluhan::create([
        'user_id' => Auth::id(),
        'kamar_id' => $request->kamar_id,
        'judul_keluhan' => $request->judul,
        'deskripsi_keluhan' => $request->isi,
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Keluhan berhasil dikirim!');
}
}
