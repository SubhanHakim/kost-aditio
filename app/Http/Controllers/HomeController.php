<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $tipeKamars = TipeKamar::with(['kamars' => function ($q) {
            $q->where('status', 'tersedia');
        }])->get();

        return view('pages.home', compact('tipeKamars'));
    }
}
