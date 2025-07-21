<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jenis;

class PencarianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jenis = jenis::all();

        return view('pencarian', compact('jenis'));
    }
}
