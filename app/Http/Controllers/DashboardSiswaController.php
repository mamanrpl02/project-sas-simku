<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardSiswaController extends Controller
{

    public function index()
    {
        return view('siswa.index');
    }
}
