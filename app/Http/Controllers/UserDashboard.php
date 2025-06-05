<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboard extends Controller
{
    public function index()
    {
        return view('user.dashboard'); // Buat file resources/views/user/dashboard.blade.php
    }
}
