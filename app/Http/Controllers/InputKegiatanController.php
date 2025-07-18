<?php

namespace App\Http\Controllers;

use App\Models\kegiatan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class InputKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $showKegiatan = kegiatan::select('nama_kegiatan', 'kode_kegiatan')
            ->orderBy('nama_kegiatan')
            ->get();

            return Datatables::of($showKegiatan)->toJson();
        }
        return view('input-kegiatan');

        // return view('input-kegiatan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kegiatan' => [
                'required',
                Rule::unique('kegiatan', 'nama_kegiatan')
            ],
            'kode_kegiatan' => [
                'required',
                Rule::unique('kegiatan', 'kode_kegiatan')
            ],
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan belum diisi',
            'nama_kegiatan.unique' => 'Nama kegiatan sudah terdaftar',
            'kode_kegiatan.required' => 'Kode kegiatan belum terisi',
            'kode_kegiatan.unique' => 'Kode kegiatan sudah terdaftar',
        ]);

        $nama = $request->input('nama_kegiatan');
        $kode = $request->input('kode_kegiatan');

        kegiatan::create([
            'nama_kegiatan' => $nama,
            'kode_kegiatan' => $kode
        ]);

        return redirect('/input-kegiatan')->with('success', 'Tambah Kegiatan berhasil');

        // dd($kegiatan);
    }
}
