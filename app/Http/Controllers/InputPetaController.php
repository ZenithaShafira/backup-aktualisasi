<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kegiatan;
use App\Models\jenis;
use App\Models\versiBS;

class InputPetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kegiatan = kegiatan::all(); // atau pakai where/ordering jika perlu
        $jenis = jenis::all();
        $versi = versiBS::all();

        return view('input-peta', compact('kegiatan', 'jenis', 'versi'));
    }
}
