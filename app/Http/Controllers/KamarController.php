<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function show($tipeKamarId)
{
    $tipeKamar = TipeKamar::findOrFail($tipeKamarId);
    $kamars = Kamar::where('tipe_kamar_id', $tipeKamarId)
        ->where('status', 'tersedia')
        ->get();

    return view('pages.detail', compact('tipeKamar', 'kamars'));
}
}
