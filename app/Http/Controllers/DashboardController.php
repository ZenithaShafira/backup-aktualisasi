<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\linkPeta;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalPeta = linkPeta::count();

        return view('dashboard', compact('totalPeta'));
    }
}
